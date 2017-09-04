<?php
namespace M152;

class Router
{
	private $routes = array();

	public function findRouteInfo(Request $request)
	{
		return $routeInfo;
	}

	public function getRouteController()
	{
		return $controller;
	} 

	public function addRoute(RouteInfo $routeInfo)
	{
		$routes[] = $r;
	}
}