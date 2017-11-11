<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Model\TestModel;
use M151\TemplateEngine;
use M151\Application;

class SecureBankingController extends Controller 
{
    public function secure_banking()
    {
        // Session Cookie nicht über JavaScript lesbar
        ini_set( 'session.cookie_httponly', 1 );
        ini_set( 'session.cookie_securey', 1 );
        // Session starten
        session_start();
        session_regenerate_id(true);   
        if(isset($_SESSION['loggedIn']))
        {
            TemplateEngine::getInstance()->smarty->assign('title', 'Banking');
            TemplateEngine::getInstance()->smarty->display('banking_welcomeback.html');
        }
        else
        {
            TemplateEngine::getInstance()->smarty->assign('title', 'Login');
            TemplateEngine::getInstance()->smarty->display('banking_login.html');
        }
    }

    public function refresh()
    {
        session_start();
        session_regenerate_id(true);
    }

    public function login()
    {
        $mail = $_POST['email'];
        $pw = $_POST['pw'];
        if($this->checkLoginCredentials($mail, $pw))
        {
            $this->loginSuccessful();
        }
        else
        {
            $this->loginFailed();
        }
        
    }

    private function checkLoginCredentials($mail, $pw)
    {
        if($mail == "much@cash.bank" && $pw == "admin")
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    private function loginSuccessful()
    {
        session_start();
        //$_SESSION['id'] = session_id();
        $_SESSION['loggedIn'] = true;
        $this->redirectTo('localhost/referat/banking');
        die();
    }

    private function loginFailed()
    {
        echo "wrong login data";
    }

    public function logout()
    {
        session_start();
        //unset($_SESSION['id']);
        unset($_SESSION['loggedIn']);
        session_destroy();
        $this->redirectTo('localhost/referat/banking');
        die();
    }

    private function redirectTo($url)
    {
        header('Location: '.$this->getProtocol().'://'.$url);
    }

    private function getProtocol()
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
