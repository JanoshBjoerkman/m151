<?php
namespace M151\Model;

class TestModel
{
    private static $_inst;
    private static $dbh;

    private $dsn = null;
    private $username = null;
    private $password = null;
    private $options = null;

    public function __construct()
    {
        $this->loadConfig();
    }

    public function loadConfig()
    {
        $this->dsn = 'mysql:host=localhost;port=3306;dbname=notekeeper';
        $this->username = 'root';
        $this->password = 'root';
        $this->options = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
    }

    public static function getInstance() 
    {
        if (!static::$_inst) 
        {
            static::$_inst = new TestModel();
        }
        return static::$_inst;
    }

    public function getConnection()
    {
        if(!static::$dbh)
        {
            static::$dbh = new \PDO($this->dsn, $this->username, $this->password, $this->options);
        }
        return static::$dbh;
    }
}