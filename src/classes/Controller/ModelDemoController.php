<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\BenutzerQB;

class ModelDemoController extends Controller 
{
    public function index(Request $req) 
    {
        //header('Content-Type: text/plain');

        // Erstelle QueryBuilder:
        $conn = Application::getInstance()->getDBconnection();
        $qb = new BenutzerQB($conn);


        // ----- Einzelner Datensatz: ------
        echo "Hole einzelnen Datensatz by ID (1):\n";
        $res = $qb->get(1);
        var_dump($res);

        // ----- Mehrere Datensätze: ------
        echo "\n\n\nHole mehrere Datensatz by SQL-Filter:\n";
        $res = $qb->query("name = 'Beutlin'",'name,vorname');
        var_dump($res);

    }
}
