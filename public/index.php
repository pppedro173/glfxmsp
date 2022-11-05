<?php

spl_autoload_register(function($class) {
    $root = dirname(__Dir__);
    $file = $root  .'/'. str_replace('\\', '/', $class) . '.php';
    if(is_readable($file)){
        require $root . '/' . str_replace('\\', '/', $class). '.php';
    }
});

$router = new Core\Router();


$router->add('/classes', 'POST', ['controller' => 'Lesson', 'action' => 'create']);
$router->add('/bookings', 'POST', ['controller' => 'Booking', 'action' => 'create']);
$router->add('/classes', 'GET', ['controller' => 'Lesson', 'action' => 'list']);
$router->add('/bookings', 'GET', ['controller' => 'Booking', 'action' => 'list']);

$path = $_SERVER['PATH_INFO'] ?? '';
$queryParams = $_SERVER['QUERY_STRING'] ?? '';
$requestType = $_SERVER['REQUEST_METHOD'] ?? '';

$url = [
    'path' => $path, 
    'queryStrings' => $queryParams
];

header('Content-Type: application/json; charset=utf-8', false, 200);

$json = file_get_contents('php://input');

$data = json_decode($json);

$router->dispatch($path, $requestType, $data);

