<?php
namespace M151;

class Request
{
	
	private $parameter = array();
	private $method;
	private $route;

	public function addRequestParameter($key, $value) 
    {
        $this->parameter[$key] = $value;
    }

    public function setMethod()
    {
    	$this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    }

    public function setRoute()
    {
    	$this->route = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
    }
}