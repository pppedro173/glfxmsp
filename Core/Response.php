<?php

namespace Core;

class Response 
{
    public static function response(int $statusCode, array $jsonData): string
    {
        if(! headers_sent()){
            header('Content-Type: application/json; charset=utf-8', false, $statusCode);
        }

        $response = json_encode($jsonData);

        echo $response;

        return $response;
    }
}