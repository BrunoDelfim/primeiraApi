<?php

$db_host = 'localhost';
$db_name = 'devsnotes';
$db_user = 'root';
$db_password = '';

$pdo = new PDO("mysql:dbname:$db_name;host=$db_host", $db_user, $db_password);

$array = [
    'error' => '',
    'result' => []
];