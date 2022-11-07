<?php

namespace App\Controllers;

use Core\Controller;
use Core\Response;

abstract class BaseController extends Controller
{
    public function success($data = [], int $statusCode): string
    {
        $response = ["data" => $data];
        return Response::response($statusCode, $response);
    }

    public function failure(?string $message, int $statusCode): string
    {
        $error = ["error" => $message];
        return Response::response($statusCode, $error);
    }
}