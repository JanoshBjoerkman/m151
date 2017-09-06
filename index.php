<?php

use M151\Application;
use M151\Router;
use M151\Controller\DefaultController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

# Definiere Routen:
Router::get('/',DefaultController::class,'index');
Router::any('/demo',DefaultController::class,'demo');
Router::any('/smarty',DefaultController::class,'smarty');

# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();