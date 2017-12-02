<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;

class LoginController extends Controller
{
    public function try_login()
    {
        if($this->allFieldsSet())
        {
            $pw = $_POST['password'];
            $data = array(
                'Email' => $this->escapeInput($_POST['email']),
            );
            try
            {
                $account = new AccountModel(Application::getInstance()->getDBconnection());
                $result = $account->select($data, TRUE);
                if(!empty($result) && password_verify($pw, $result[0]['Passwort']))
                {
                    $this->session->login($result[0]['ID'], $result[0]['is_admin']);
                    $this->redirect_to("home");
                }
                else
                {
                    // email and/or password didn't match
                    $this->view->show_error_message(
                        "Fehler",
                        "Email-Adresse oder Passwort nicht korrekt:",
                        "Fehler:",
                        "Bitte überprüfen Sie Ihre Eingabe."
                    );
                }
            }
            catch(\Exception $e)
            {
                // TODO: error message
            }
        }
        else
        {
            $this->redirect_to("home");
        }
    }

    private function allFieldsSet()
    {
        $allSet = isset($_POST['email']) && isset($_POST['password']);
        if($allSet)
        {
            return true;
        }
        return false;
    }
}