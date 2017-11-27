<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\TemplateEngine;
use M151\Model\Account;

class RegisterController extends Controller
{
    public function register_form()
    {
        $content = array(
            'title' => 'Registration',
            'page_title' => 'Ferienpass-Konto erstellen',
        );
        TemplateEngine::getInstance()->smarty->assign($content);
        TemplateEngine::getInstance()->smarty->display('register_form.html');
    }

    public function try(Request $req)
    {
        if($this->allFieldsSet())
        {
            $email = $this->escapeString($_POST['email']);
            $pw1 = $this->escapeString($_POST['password1']);
            $pw2 = $this->escapeString($_POST['password2']);
            $address = $this->escapeString($_POST['address']);
            $ort = $this->escapeString($_POST['ort']);
            $plz = $this->escapeString($_POST['plz']);
            $acc = new AccountModel(Application::getInstance()->getDBconnection());
            $acc->getUser($email);
        }
    }

    private function allFieldsSet()
    {
        $allSet = isset($_POST['email']) &&
                  isset($_POST['password1']) &&
                  isset($_POST['password2']) &&
                  isset($_POST['address']) &&
                  isset($_POST['ort']) &&
                  isset($_POST['plz']);
        if($allSet)
        {
            return true;
        }
        return false;
    }
}