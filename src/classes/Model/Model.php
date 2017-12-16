<?php

namespace M151\Model;

abstract class Model 
{
    protected $DBH = null;

    abstract function tablename();
    
    public function __construct(\PDO $connection) 
    {
        $this->DBH = $connection;
        // reference: https://code.tutsplus.com/tutorials/why-you-should-be-using-phps-pdo-for-database-access--net-12059
        $this->DBH->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function insert($dataDictionary)
    {
        $columns = $this->prepareColumnNames(array_keys($dataDictionary));
        $namedPlaceholders = $this->prepareNamedPlaceholders(array_keys($dataDictionary));

        $STH = $this->DBH->prepare("INSERT INTO {$this->tablename()} ({$columns}) VALUES ({$namedPlaceholders})");
        $result = $STH->execute($dataDictionary);
        return $result;
    }

    public function update($set, $where)
    {
        $SET = $this->prepareNamedPlaceholdersForSet(array_keys($set));
        $WHERE  = $this->prepareNamedPlaceholdersForWhere(array_keys($where), "AND");
        $STH = $this->DBH->prepare("UPDATE {$this->tablename()} SET {$SET} WHERE {$WHERE}");
        return $STH->execute(array_merge_recursive($set, $where));
    }

    public function delete($data, $logic = "AND")
    {
        $where = $this->prepareNamedPlaceholdersForWhere(array_keys($data), $logic);
        $query = "DELETE FROM {$this->tablename()} WHERE {$where}";
        $STH = $this->DBH->prepare($query);
        $result = $STH->execute($data);
        return $result;
    }

    public function select_all($orderBy = NULL)
    {
        $query = "";
        if($orderBy == NULL)
        {
            $query = "SELECT * FROM {$this->tablename()}";
        }
        else
        {
            $query = "SELECT * FROM {$this->tablename()} ORDER BY {$orderBy}";
        }
        $STH = $this->DBH->prepare($query);
        $result = $STH->execute();
        if($result)
        {
            return $STH->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function select($dataDictionary, $selectAllColumns, $logic = "AND", $orderBy = "ID")
    {
        $columns = $this->prepareColumnNames(array_keys($dataDictionary));
        $where = $this->prepareNamedPlaceholdersForWhere(array_keys($dataDictionary), $logic);

        $query = "";
        if($selectAllColumns)
        {
            $query = "SELECT * FROM {$this->tablename()} WHERE {$where} ORDER BY {$orderBy}";
        }
        else
        {
            $query = "SELECT {$columns} FROM {$this->tablename()} WHERE {$where} ORDER BY {$orderBy}";
        }

        $STH = $this->DBH->prepare($query);
        $result = $STH->execute($dataDictionary);
        if($result)
        {
            // emtpy array means no rows with specified filter ($dataDictionary) found
            return $STH->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    protected function prepareColumnNames($keys)
    {
		return join(',',$keys);
    }

    protected function prepareNamedPlaceholders($keys)
    {
        $placeholders = array();
        foreach($keys as $key => $value)
        {
            $placeholders[] = ':'.$value;
        }
        return join(',', $placeholders);
    }

    protected function prepareNamedPlaceholdersForWhere($keys, $logic)
    {
        $placeholders = array();
        foreach($keys as $key => $value)
        {
            $placeholders[] = "({$value} = :{$value})";
        }
        return join($logic, $placeholders);
    }

    protected function prepareNamedPlaceholdersForSet($keys)
    {
        $placeholders = array();
        foreach($keys as $key => $value)
        {
            $placeholders[] = "{$value} = :{$value}";
        }
        return join(",", $placeholders);
    }

    public function getLastInsertedID()
    {
        return $this->DBH->lastInsertID();
    }
}