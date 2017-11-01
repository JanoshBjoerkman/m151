<?php

use M151\Application;
use M151\Router;
use M151\Controller\DefaultController;
use M151\Controller\BankingController;
use M151\Controller\RipforumController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

// Normale Website
Router::get('/', BankingController::class, 'banking');  // so quasi "index.php"
Router::post('/banking_trylogin', BankingController::class, 'login');  // verarbeitet abgeschicktes Loginformular
Router::get('/logout', BankingController::class, 'logout');


Router::get('/ripforum', RipforumController::class, 'ripforum');


# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();