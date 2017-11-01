<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Model\TestModel;
use M151\TemplateEngine;
use M151\Application;

class BankingController extends Controller 
{
    public function banking()
    {
        session_start();
        if(isset($_SESSION['id']))
        {
            TemplateEngine::getInstance()->smarty->assign('title', 'Banking');
            TemplateEngine::getInstance()->smarty->display('banking_welcomeback.tpl');
        }
        else
        {
            TemplateEngine::getInstance()->smarty->assign('title', 'Login');
            TemplateEngine::getInstance()->smarty->display('banking_login.tpl');
        }
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

    public function logout()
    {
        session_start();
        $_SESSION['id'] = null;
        session_destroy();
        header('Location: '.'http://localhost/referat/');
        die();
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
        $_SESSION['id'] = session_id();
        header('Location: '.'http://localhost/referat/');
        die();
    }

    private function loginFailed()
    {
        echo "wrong login data";
    }
}
