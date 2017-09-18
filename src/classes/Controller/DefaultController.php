<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\View\View;
use M151\Model\TestModel;

class DefaultController extends Controller 
{
    public function index(Request $req) 
    {
        header('Content-Type: text/plain');
        echo "Route: {$req->urlRoute}\n";
        foreach($req->getParams() as $key=>$value) 
        {
            echo "Param: {$key} => {$value}\n";
        }
    }

    public function demo(Request $req) 
    {
        $view = new View('default-demo.html');
        $view->assign('route',$req->urlRoute);
        $view->assign('params',$req->getParams());
        $view->render();
    }

    public function smarty(Request $req)
    {

        $smarty = new \Smarty();
        $smarty->setTemplateDir(dirname(__FILE__).'/../../engine/templates/');
        $smarty->setCompileDir(dirname(__FILE__).'/../../engine/templates_c');
        $smarty->setConfigDir(dirname(__FILE__).'/../../engine/configs/');
        $smarty->setCacheDir(dirname(__FILE__).'/../../engine/cache/');

        $smarty->testInstall();

        $smarty->assign('name', 'Björk');
        print_r($smarty->getTemplateDir());
        print_r($smarty->getConfigVars());
        $smarty->display('test.tpl');
    }

    public function testCon()
    {
        $model = TestModel::getInstance();
        $con =$model->getConnection();
        if($con)
        {
            echo "hell yess";
        }
    }
}
