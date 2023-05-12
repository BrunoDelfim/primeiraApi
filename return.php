<?php

/**

 **/

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");

/** @var $array $array */
echo json_encode($array);
exit;