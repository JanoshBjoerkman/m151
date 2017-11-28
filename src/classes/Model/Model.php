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

    protected function insert($dataDictionary)
    {
        $columns = $this->prepareColumnNames(array_keys($dataDictionary));
        $namedPlaceholders = $this->prepareNamedPlaceholders(array_keys($dataDictionary));
        try 
        {
            $STH = $this->DBH->prepare("INSERT INTO {$this->tablename()} ({$columns}) VALUES ({$namedPlaceholders})");
            $result = $STH->execute($dataDictionary);
            return $result;
        }
        catch(PDOException $e)
        {
            // TODO: Errorsite
        }
    }

    protected function select($dataDictionary, $logic = "AND")
    {
        $columns = $this->prepareColumnNames(array_keys($dataDictionary));
        $where = $this->prepareNamedPlaceholdersForWhere(array_keys($dataDictionary), $logic);
        try
        {
            $STH = $this->DBH->prepare("SELECT {$columns} FROM {$this->tablename()} WHERE {$where}");
            $result = $STH->execute($dataDictionary);
            if($result)
            {
                // emtpy array means no rows with specified filter found
                return $STH->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        catch(PDOException $e)
        {
            // TODO: Errorsite
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
        return join("$logic", $placeholders);
    }
}