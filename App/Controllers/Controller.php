<?php

namespace App\Controllers;

use Core\Controller as BaseController;
use Core\Response;

abstract class Controller extends BaseController
{
    public function success($data = [], int $statusCode): void
    {
        $response = ["data" => $data];
        Response::response($statusCode, $response);
    }

    public function failure(?string $message, int $statusCode): void
    {
        $error = ["error" => $message];
        Response::response($statusCode, $error);
    }
}