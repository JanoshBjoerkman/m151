<?php

namespace M151;

use M151\Http\Request;

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
}
