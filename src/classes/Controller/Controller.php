<?php
namespace M151\Controller;

use M151\TemplateEngine;
use M151\SessionHandler;

class Controller 
{
    private $basePath;
    protected $session;
    protected $view;

    public function __construct() 
    {
        $this->basePath = 'localhost/web151/';
        $this->session = SessionHandler::getHandler();
        $this->view = TemplateEngine::getInstance();
    }

    public function info()
    {
        phpinfo();        
    }

    // seen on: https://stackoverflow.com/questions/110575/do-htmlspecialchars-and-mysql-real-escape-string-keep-my-php-code-safe-from-inje
    protected function escapeInput($str)
    {
        $new = mb_convert_encoding($str, 'UTF-8', 'UTF-8');
        $new = htmlentities($str, ENT_QUOTES, 'UTF-8');
        return $new;
    }

    protected function hash_pw($pw)
    {
        return password_hash($pw, PASSWORD_DEFAULT);
    }

    protected function redirect_to($url)
    {
        header('Location: '.$this->getHref($url));
    }

    protected function adminAndLoggedInCheck()
    {
        if($this->session->isLoggedIn() && $this->session->isAdmin())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function getHref($url)
    {
        return $this->getBasePathWithProtocol().$url;
    }

    protected function getBasePathWithProtocol()
    {
        return $this->getProtocol().'://'.$this->basePath;
    }

    protected function getProtocol()
    {
        return 'https';
        /*
        if(isset($_SERVER['HTTPS']))
        {
            if(\strtoupper($_SERVER['HTTPS']) == 'ON')
            {
                return 'https';
            }
        }
        return 'http';
        */
    }
}
