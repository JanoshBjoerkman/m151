<?php

namespace M151\Http;

class Request {
    private $_origRequest;
    private $_serverInfo;

    public $urlRoute = '/';
    public $method = 'GET';

    public function __construct($request, $serverInfo) 
    {
        $this->_origRequest = $request;
        $this->_serverInfo = $serverInfo;

        $this->urlRoute = isset($this->_serverInfo['PATH_INFO']) ? $this->_serverInfo['PATH_INFO'] : '/';
        $this->method = isset($this->_serverInfo['REQUEST_METHOD']) ? $this->_serverInfo['REQUEST_METHOD'] : 'GET';
    }

    public function getParams() 
    {
        if (is_array($this->_origRequest)) {
            return $this->_origRequest;
        } else {
            return [];
        }
    }

    public function getParam($name,$default = null) 
    {
        if (!empty($this->_origRequest[$name]))
        {
            return $this->_origRequest[$name];
        } 
        else 
        {
            return $default;
        }
    }

}
