<?php

use M151\Application;
use M151\Router;
use M151\Controller\Controller;
use M151\Controller\LoginController;
use M151\Controller\LogoutController;
use M151\Controller\RegisterController;
use M151\Controller\HomeController;
use M151\Controller\ManageController;
use M151\Controller\ResourceController;
use M151\Controller\AjaxDemoController;

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

######### testing routes #########
Router::get('/info', Controller::class, 'info');
// testing ajax
Router::any('/ajax', AjaxDemoController::class, 'index');
Router::get('/ajax/loadUsers', AjaxDemoController::class, 'getUsers');

######### productive routes #########
# home
Router::get('/', HomeController::class, 'home');
Router::get('/home', HomeController::class, 'home');
Router::get('/home/persons', HomeController::class, 'persons');
Router::get('/home/settings', HomeController::class, 'settings');
# login
Router::post('/login', LoginController::class, 'try_login');
# logout
Router::get('/logout', LogoutController::class, 'logout');
# registration
Router::get('/register', RegisterController::class, 'register_form');
Router::post('/register', RegisterController::class, 'try_to_register');
# manage
Router::get('/manage', ManageController::class, 'manage');
Router::get('/manage/settings', ManageController::class, 'settings');
Router::post('/manage/new_event', ManageController::class, 'create_new_event');
Router::post('/manage/delete_event', ManageController::class, 'delete_event');
Router::post('/manage/refresh_events_table', ManageController::class, 'refresh_events_table');
Router::post('/manage/new_course', ManageController::class, 'create_new_course');
Router::post('/manage/add_course_day', ManageController::class, 'add_course_day');
# resources
Router::get('/resources/js/script.js', ResourceController::class, 'own_js');

# Übergebe an Applikation:
$app = Application::getInstance();
$app->start();
