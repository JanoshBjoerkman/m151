<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\TemplateEngine;

class HomeController extends Controller
{
    public function home(Request $req)
    {
        $this->session->refresh();
        if(isset($_SESSION['Account_ID']))
        {
            $this->welcomeBack($req);
        }
        else
        {
            $this->entry_point();
        }
    }

    public function welcomeBack(Request $request)
    {
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
            "li_class_meine_kurse" => $li_class_meine_kurse

        );
        $this->view->smarty->assign($content);
        $this->view->smarty->display('home.html');
    }

    public function entry_point()
    {
        $content = array(
            'tab_title' => "Ferienpass",
            'page_header' => "Ferienpass Pfyn"
        );
        $this->view->smarty->assign($content);
        $this->view->smarty->display('entry_point.html');
    }
}