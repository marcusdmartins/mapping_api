<?php

set_time_limit(0);
header('Access-Control-Allow-Origin: *');
header("Content-Type: text/html; charset=UTF-8", true);

include_once ('./db/ConnectionFactory.php');

$data = file_get_contents("php://input");
$filter = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
//$filter == "GET" ou "POST"

$_GET['url'] = (isset($_GET['url'])) ? $_GET['url'] : 'index/index';
$key = $_GET['url'];
$router = explode("/", $_GET['url']);
$controller = $router[0];
$action = (empty($router[1])) ? 'index' : $router[1];

require_once ('./api/' . $controller . '.php');
$app = new $controller();
if (empty($data) || $data == null) {
	$app -> $action();
} else {
	$app -> $action($data);
}

