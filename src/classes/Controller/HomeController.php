<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;
use M151\View\HomeView;

class HomeController extends Controller
{
    public function home(Request $req)
    {
        $this->session->refresh();
        $this->view = new HomeView();
        if($this->session->isLoggedIn())
        {
            $this->welcomeBack($req);
        }
        else
        {
            // not logged in
            $this->entry_point();
        }
    }

    protected function welcomeBack(Request $request)
    {
        $account = new AccountModel(Application::getInstance()->getDBconnection());
        $Account_Email = $account->get_email_by_id($_SESSION['Account_ID']);

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
        $this->view->show_home($content);
    }

    protected function entry_point()
    {
        $content = array(
            'tab_title' => "Ferienpass",
            'page_header' => "Ferienpass Pfyn"
        );
        $this->view->show_entry_point($content);
        
    }

    public function persons()
    {

    }

    public function settings()
    {

    }
}