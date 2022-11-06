<?php

namespace App\Controllers;

use Core\Controller;
use Core\Response;

abstract class BaseController extends Controller
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