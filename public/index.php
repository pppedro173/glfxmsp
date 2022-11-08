<?php

require_once '../vendor/autoload.php';

set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

$router->add('/classes', 'POST', ['controller' => 'LessonController', 'action' => 'create']);
$router->add('/bookings', 'POST', ['controller' => 'BookingController', 'action' => 'create']);
$router->add('/classes', 'GET', ['controller' => 'LessonController', 'action' => 'list']);
$router->add('/bookings', 'GET', ['controller' => 'BookingController', 'action' => 'list']);

$path = $_SERVER['PATH_INFO'] ?? '';
$requestType = $_SERVER['REQUEST_METHOD'] ?? '';

$json = file_get_contents('php://input');

$data = json_decode($json);

$router->dispatch($path, $requestType, $data);

