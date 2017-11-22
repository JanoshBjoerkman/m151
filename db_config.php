<?php

$this->dsn = 'mysql:host=localhost;port=3306;dbname=Ferienpass';
$this->username = 'root';
$this->password = 'root';
$this->options = array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);