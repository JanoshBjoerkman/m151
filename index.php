<?php

use M151\Application;
use M151\Router;
use M151\Controller\DefaultController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

# Definiere Routen:
Router::get('/', DefaultController::class, 'index');
// testing mvc routing
Router::any('/demo', DefaultController::class, 'demo');
// testing smarty
Router::any('/smarty', DefaultController::class, 'smarty');
Router::any('/smarty2', DefaultController::class, 'externsmarty');
// testing db
Router::any('/connection', DefaultController::class, 'testCon');
Router::get('/login_form', DefaultController::class, 'get_login_form');
Router::post('/login_try', DefaultController::class, 'login_try');
Router::any('/querybuilder', ModelDemoController::class, 'index');

# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();