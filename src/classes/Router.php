<?php

namespace M151;

use M151\Http\Request;

class Router {
    private static $_routes = [];

    public static function addRoute($route, $httpMethod, $controllerClass, $actionFn) 
    {
        static::$_routes[] = [
            'method' => $httpMethod,
            'route' => $route,
            'controller' => $controllerClass,
            'action' => $actionFn
        ];
    }

    public static function get($route, $controllerClass, $actionFn) 
    {
        static::addRoute($route, 'GET', $controllerClass, $actionFn);
    }

    public static function post($route, $controllerClass, $actionFn) 
    {
        static::addRoute($route, 'POST', $controllerClass, $actionFn);
    }

    public static function put($route, $controllerClass, $actionFn) 
    {
        static::addRoute($route, 'PUT', $controllerClass, $actionFn);
    }

    public static function delete($route, $controllerClass, $actionFn) 
    {
        static::addRoute($route, 'DELETE', $controllerClass, $actionFn);
    }

    public static function any($route, $controllerClass, $actionFn) 
    {
        static::addRoute($route, null, $controllerClass, $actionFn);
    }

    public static function findRouteInfo(Request $req) 
    {
        $route = $req->urlRoute;
        $method = $req->method;

        foreach(static::$_routes as $routeInfo) 
        {
            if ($routeInfo['route'] === $route && ($routeInfo['method'] === null || $method === $routeInfo['method'])) 
            {
                return $routeInfo;
            }
        }
        // TODO: 404 template
        throw new \Exception('No route found for '.$method.'::'.$route);
    }

    public static function getRouteController($routeInfo) 
    {
        $ctrl = $routeInfo['controller'];
        $c = new $ctrl();
        return $c;
    }
}
