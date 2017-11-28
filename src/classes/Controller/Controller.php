<?php
namespace M151\Controller;

class Controller 
{
    public function __construct() 
    {
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
        header('Location: '.$this->getProtocol().'://'.$url);
    }

    protected function getProtocol()
    {
        if(isset($_SERVER['HTTPS']))
        {
            if(\strtoupper($_SERVER['HTTPS']) == 'ON')
            {
                return 'https';
            }
        }
        return 'http';
    }
}
