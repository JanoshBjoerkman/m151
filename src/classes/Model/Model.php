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
        $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function insert($dataDictionary)
    {
        $columns = prepareColumnNames(array_keys($dataDictionary));
        $namedPlaceholders = prepareNamedPlaceholders(array_keys($dataDictionary));
        $STH = $this->DBH->prepare("INSERT INTO {$tablename} ({$columns}) VALUES ({$namedPlaceholders})");
    }

    protected function prepareColumnNames($keys)
    {
        $columns = array_keys($keys);
		return join(',',$columns);
    }

    protected function prepareNamedPlaceholders($keys)
    {
        $placeholders = array();
        foreach($keys as $key)
        {
            $placeholders[] = ":".$key;
        }
        return join(',', $placeholders);
    }
}