<?php

namespace M151;

use M151\Http\Request;
use M151\TemplateEngine;

class Application 
{
    private static $_inst;
    private $dbConnection;

    public $request = null;
    public $controller = null;
    public $routeInfo = null;

    private function __construct() 
    {
        $this->request = new Request($_REQUEST, $_SERVER);
    }

    public static function getInstance() 
    {
        if (!static::$_inst) 
        {
            static::$_inst = new Application();
        }
        return static::$_inst;
    }

    public function start() 
    {
        $routeInfo = Router::findRouteInfo($this->request);
        $controller = Router::getRouteController($routeInfo);
        $this->controller = $controller;
        $this->routeInfo = $routeInfo;
        $actionFn = $routeInfo['action'];
        $ret = $controller->$actionFn($this->request);
    }

    public function getDBconnection()
    {
        if(!$this->dbConnection)
        {
            // loadconfig
            require(__DIR__.'/../../db_config.php');
            try
            {
                $this->dbConnection = new \PDO($this->dsn, $this->username, $this->password, $this->options);
            }
            catch(\PDOException $e)
            {
                $content = array(
                    'tab_title' => 'Datenbankfehler',
                    'h1' => 'Keine Verbindung zur Datenbank',
                    'alert_title' => '503',
                    'alert_body' => 'Die Verbindung zur Datenbank konnte nicht hergestellt werden. Bitte wenden Sie sich an den Administrator.'
                );
                TemplateEngine::getInstance()->smarty->assign($content);
                TemplateEngine::getInstance()->smarty->display('error_message.html');
            }
        }
        return $this->dbConnection;
    }
}
