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
            $this->welcomeBack();
        }
        else
        {
            $this->entry_point();
        }
    }

    public function welcomeBack()
    {
        $content = array(
            "tab_title" => "Home",

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