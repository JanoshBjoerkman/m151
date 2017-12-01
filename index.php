<?php

use M151\Application;
use M151\Router;
use M151\Controller\Controller;
use M151\Controller\DefaultController;
use M151\Controller\HomeController;
use M151\Controller\ModelDemoController;
use M151\Controller\AjaxDemoController;
use M151\Controller\RegisterController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

######### testin routes #########
Router::get('/info', Controller::class, 'info');
// testing mvc routing
Router::any('/demo', DefaultController::class, 'demo');
// testing smarty
Router::any('/smarty', DefaultController::class, 'smarty');
Router::any('/smarty2', DefaultController::class, 'externsmarty');
// testing db
Router::any('/connection', DefaultController::class, 'testCon');
Router::get('/login_form', DefaultController::class, 'get_login_form');
Router::post('/login_try', DefaultController::class, 'login_try');
// testing query builder
Router::any('/querybuilder', ModelDemoController::class, 'index');
// testing ajax
Router::any('/ajax', AjaxDemoController::class, 'index');
Router::get('/ajax/loadUsers', AjaxDemoController::class, 'getUsers');

######### productive routes #########
# home
Router::get('/', HomeController::class, 'home');
Router::get('/home', HomeController::class, 'home');
# registration
Router::get('/register', RegisterController::class, 'register_form');
Router::post('/register', RegisterController::class, 'try_to_register');

# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();
