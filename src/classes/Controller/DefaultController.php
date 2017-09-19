<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\View\View;
use M151\Model\TestModel;
use M151\TemplateEngine;

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

        $smarty->assign('name', 'Björk');
        $smarty->display('test.tpl');
    }

    public function externsmarty()
    {
        TemplateEngine::getInstance()->smarty->assign('name', 'ooh Björk');
        TemplateEngine::getInstance()->smarty->display('extern_test.tpl');
    }

    public function get_login_form()
    {
        TemplateEngine::getInstance()->smarty->display('login_form.tpl');
    }

    public function login_try()
    {
        $login = $_POST['login'];
        $passwort = $_POST['passwort'];
        echo "Ihre Eingabe: {$login}, {$passwort}";

        if($this->testCon())
        {
            $con = TestModel::getInstance()->getConnection();
            $stm = $con->query("SELECT * FROM benutzer WHERE login = '{$login}' AND passwort = '{$passwort}'");
            
            // PDOStatement auslesen: fetch() holt den nächsten Record, fetchAll() holt alle Records:
            $result = $stm->fetch();
            // Ausgabe des Resultats:
            if ($result) {
            echo "<div style='background-color: green; padding: 1em;'>Hallo, {$result['vorname']}!</div>";
            } else {
            // oder Fehlerausgabe:
            echo "<p>Ooops, Login-Fehler!</p>";
            }
        }

    }

    public function testCon()
    {
        $model = TestModel::getInstance();
        $con = $model->getConnection();
        if($con)
        {
            return true;
        }
        return false;
    }
}
