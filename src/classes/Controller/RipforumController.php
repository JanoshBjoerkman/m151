<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Model\TestModel;
use M151\TemplateEngine;
use M151\Application;

class RipforumController extends Controller 
{
    public function ripforum()
    {
        TemplateEngine::getInstance()->smarty->assign('title', 'Hella lit');
        TemplateEngine::getInstance()->smarty->display('banking_login.tpl');
    }
}
