<?php

use M151\Application;
use M151\Router;
use M151\Controller\BankingController;
use M151\Controller\SecureBankingController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

// Normale Website
Router::post('/banking_trylogin', BankingController::class, 'login');  // verarbeitet abgeschicktes Loginformular
Router::get('/logout', BankingController::class, 'logout');
Router::get('/banking', BankingController::class, 'banking');  // so quasi "index.php"

// // sichere Website
// Router::get('/banking', SecureBankingController::class, 'secure_banking');
// Router::post('/banking_trylogin', SecureBankingController::class, 'login');
// Router::get('/logout', SecureBankingController::class, 'logout');
// Router::get('/heartbeat', SecureBankingController::class, 'refresh');


# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();