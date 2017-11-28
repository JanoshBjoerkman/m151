<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\TemplateEngine;
use M151\Model\AccountModel;

class RegisterController extends Controller
{
    public function show_register_form()
    {
        $content = array(
            'title' => 'Registration',
            'page_title' => 'Ferienpass-Konto erstellen',
        );
        TemplateEngine::getInstance()->smarty->assign($content);
        TemplateEngine::getInstance()->smarty->display('register_form.html');
    }

    public function try_to_register(Request $req)
    {
        if($this->allFieldsSet())
        {
            // safe passwords
            $pw1 = $this->escapeInput($_POST['password1']);
            $pw2 = $this->escapeInput($_POST['password2']);
            // prepare data dictionary 
            $data = array(
                'Email' => $this->escapeInput($_POST['email']),
                'Passwort' => $this->hash_pw($pw1),
                'Rechnungsadresse' => $this->escapeInput($_POST['address']),
                'Ort' => $this->escapeInput($_POST['ort']),
                'PLZ' => $this->escapeInput($_POST['plz'])
            );
            $account = new AccountModel(Application::getInstance()->getDBconnection());
            $accountsWithSameEmail = $account->get_account_by_email($data['Email']);
            // no query execution error occured
            if(empty($accountsWithSameEmail))
            {
                // account doesn't exist yet
                if($pw1 == $pw2)
                {
                    // hell yeah, user managed to type the same passwords 
                    $account->create_new_account($data);
                    $this->redirect_to('localhost/web151/home');
                }
                else
                {
                    // user fucked up passwords
                    $content = array(
                        'page_title' => "Fehler",
                        'h1' => "Leider ist etwas schiefgelaufen...",
                        'alert_title' => "Fehler:",
                        'alert_body' => "Die eingegebenen Passwörter stimmen nicht überein. Der Vorgang wurde abgebrochen."
                    );
                    TemplateEngine::getInstance()->smarty->assign($content);
                    TemplateEngine::getInstance()->smarty->display('error_message.html');
                }
            }
            else
            {
                $content = array(
                    'page_title' => "Fehler",
                    'h1' => "Leider ist etwas schiefgelaufen...",
                    'alert_title' => "Fehler:",
                    'alert_body' => "Der Benutzer mit der angegebenen Email-Adresse: {$data['Email']} existiert bereits."
                );
                TemplateEngine::getInstance()->smarty->assign($content);
                TemplateEngine::getInstance()->smarty->display('error_message.html');
            }
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