<?php

require '../Core/Router.php';
require '../App/Controllers/Lesson.php';
require '../App/Controllers/Booking.php';


$router = new Router();


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


$router->dispatch($path, $requestType);

