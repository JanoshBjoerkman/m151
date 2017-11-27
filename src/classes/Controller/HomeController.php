<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\TemplateEngine;

class HomeController extends Controller
{
    public function home(Request $req)
    {
        echo "welcome";
    }
}