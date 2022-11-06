<?php

namespace Core;

class Response 
{
    public static function response(int $statusCode, array $jsonData): void
    {
        header('Content-Type: application/json; charset=utf-8', false, $statusCode);

        echo json_encode($jsonData);
        die();
    }
}