<?php
header('Content-type: text/plain');
$db = new PDO('mysql:host=localhost;port=3306','root','root');
var_dump($db->query('SHOW DATABASES')->fetchAll());