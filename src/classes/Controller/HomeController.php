<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;

class HomeController extends Controller
{
    public function home(Request $req)
    {
        $this->session->refresh();
        if($this->session->isLoggedIn())
        {
            // user is logged in
            if($this->session->isAdmin())
            {
                // user is admin
                $this->redirect_to("manage");
            }
            else
            {
                // normal user
                $this->welcomeBack($req);
            }
        }
        else
        {
            // not logged in
            $this->entry_point();
        }
    }

    protected function welcomeBack(Request $request)
    {
        $Account_Email = "";
        $data = array(
            'ID' => $_SESSION['Account_ID'],
        );
        $account = new AccountModel(Application::getInstance()->getDBconnection());
        $result = $account->select($data, TRUE);
        if(!empty($result))
        {
            $Account_Email = $result[0]['Email'];
        }

        $li_class_kurse = 'active';
        $li_class_meine_kurse = "";
        if($request->getParam('active') != NULL)
        {
            switch($request->getParam('active'))
            {
                case 'c':
                    $li_class_kurse = 'active';
                    $li_class_meine_kurse = '';
                    break;
                case 'my':
                    $li_class_kurse = '';
                    $li_class_meine_kurse = 'active';
                    break;
            }
        }

        $content = array(
            "tab_title" => "Home",
            "href_kurse" => $this->getHref("home?active=c"),
            "href_meine_kurse" => $this->getHref("home?active=my"),
            "li_class_kurse" => $li_class_kurse,
            "li_class_meine_kurse" => $li_class_meine_kurse,
            "Account_Email" => $Account_Email,
            "href_personen" => $this->getHref("home/persons"),
            "href_einstellungen" => $this->getHref("home/settings"),
            "href_logout" => $this->getHref("logout")
        );
        $this->view->smarty->assign($content);
        $this->view->smarty->display('home.html');
    }

    protected function entry_point()
    {
        $content = array(
            'tab_title' => "Ferienpass",
            'page_header' => "Ferienpass Pfyn"
        );
        $this->view->smarty->assign($content);
        $this->view->smarty->display('entry_point.html');
    }

    public function persons()
    {

    }

    public function settings()
    {

    }
}