<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\View\View;
use M151\Application;

class AjaxDemoController extends Controller 
{
    public function index(Request $req) 
    {
        $view = new View('ajax-demo.html');
        $view->render();
    }

    public function getUsers(Request $req) 
    {
        $conn = Application::getInstance()->getDBconnection();
        $res = $conn->query("SELECT * FROM benutzer ORDER BY login")->fetchAll(\PDO::FETCH_ASSOC);

        if ($req->getParam('contentType') === 'json') {
            // als JSON-Daten ausgeben:
            header('Content-Type: application/json');
            echo json_encode($res);
        } else {
            // als HTML-Daten ausgeben:
            $view = new View('ajax-demo-userlist.html');
            $view->assign('users',$res);
            $view->render();
        }
    }
}
