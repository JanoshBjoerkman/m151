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
            echo "welcome back mf :)";
        }
        else
        {
            echo "pls login to use this service";
        }
    }
}