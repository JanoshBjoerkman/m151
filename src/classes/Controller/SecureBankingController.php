<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Model\TestModel;
use M151\TemplateEngine;
use M151\Application;

class SecureBankingController extends Controller 
{
    // Generell: HTTPS verwenden!
    public function secure_banking()
    {
        // Immer ein Session Cookie verwenden, $_GET['PHPSESSID'] ist invalid -> siehe: http://packetcode.com/article/preventing-session-hijacking-in-php
        ini_set( 'session.use_only_cookies', TRUE );				
        ini_set( 'session.use_trans_sid', FALSE );
        // Cookies nur über HTTPS versenden -> siehe: https://stackoverflow.com/questions/25047170/php-session-cookie-secure-disables-sessions-when-set-to-true
        ini_set( 'session.cookie_secure', TRUE );
        
        $this->refresh();

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
        session_unset();
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
