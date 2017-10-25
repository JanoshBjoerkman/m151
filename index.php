<?php

use M151\Application;
use M151\Router;
use M151\Controller\DefaultController;
use M151\Controller\ModelDemoController;
use M151\Controller\AjaxDemoController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

# Definiere Routen:
Router::get('/', DefaultController::class, 'index');
// testing smarty;
Router::any('/smarty2', DefaultController::class, 'externsmarty');
// testing db
Router::get('/login_form', DefaultController::class, 'get_login_form');
Router::post('/login_try', DefaultController::class, 'login_try');
// testing query builder
Router::any('/querybuilder', ModelDemoController::class, 'index');
// testing ajax
Router::any('/ajax', AjaxDemoController::class, 'index');
Router::get('/ajax/loadUsers', AjaxDemoController::class, 'getUsers');

# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();