<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;

class RegisterController extends Controller
{
    public function register_form()
    {
        $this->view->show_register_form();
    }

    public function try_to_register(Request $req)
    {
        if($this->allFieldsSet())
        {
            // safe passwords
            $pw1 = ($_POST['password1']);
            $pw2 = ($_POST['password2']);
            // prepare data dictionary 
            $data = array(
                'Email' => $this->escapeInput($_POST['email']),
                'Passwort' => $this->hash_pw($pw1),
                'Rechnungsadresse' => $this->escapeInput($_POST['address']),
                'Ort' => $this->escapeInput($_POST['ort']),
                'PLZ' => $this->escapeInput($_POST['plz'])
            );
            try
            {
                $account = new AccountModel(Application::getInstance()->getDBconnection());
                $accountsWithSameEmail = $account->get_account_by_email($data['Email']);
            
                if(empty($accountsWithSameEmail))
                {
                    // account doesn't exist yet
                    if($pw1 == $pw2)
                    {
                        // hell yeah, user managed to type the same passwords 
                        $account->create_new_account($data);
                        $ID = $account->getLastInsertedID();
                        $this->session->login($ID);
                        $this->redirect_to('home');
                    }
                    else
                    {
                        // user fucked up passwords
                        $this->view->show_error_message(
                            "Fehler",
                            "Leider ist etwas schiefgelaufen...",
                            "Fehler:",
                            "Die eingegebenen Passwörter stimmen nicht überein. Der Vorgang wurde abgebrochen."
                        );
                    }
                }
                else
                {
                    // account already exists
                    $this->view->show_error_message(
                        "Fehler",
                        "Leider ist etwas schiefgelaufen...",
                        "Fehler:",
                        "Der Benutzer mit der angegebenen Email-Adresse: {$data['Email']} existiert bereits."
                    );
                }
            }
            catch(\Exception $e)
            {
                $this->view->show_error_message(
                    "Datenbank-Fehler",
                    "Leider ist etwas schiefgelaufen...",
                    "Fehler:",
                    "Versuchen Sie es zu einem späteren Zeitpunkt oder wenden Sie sich an den Administrator."
                );                
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
        $notEmpty = (!empty($_POST['email']) &&
            !empty($_POST['password1']) &&
            !empty($_POST['password2']) &&
            !empty($_POST['address']) &&
            !empty($_POST['ort']) &&
            !empty($_POST['plz'])
            );
        if($allSet && $notEmpty)
        {
            return true;
        }
        return false;
    }
}