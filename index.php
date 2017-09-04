<?php

# lade composer autoloader:
require_once(__DIR__.'/vendor/autoload.php');

# setze Output-Type auf Plaintext, für debugging-Ausgabe:
header('Content-Type: text/plain');

# extrahiere URL-Route:
$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
echo "requested route: {$path_info}\n";
echo "requested params: ".print_r($_REQUEST,true)."\n";

# Teste Auto-Loading (siehe composer.json):
#$test = new M151\Test();
#$test->hello();

$request = new M151\Request();

// fill $_REQUEST in class array
foreach ($_REQUEST as $key => $value)
{
	$request->addRequestParameter($key, $value);
}

$request->setMethod();
$request->setRoute();

$app = new M151\Application();
$app->setRequest($request);
$app->start();


