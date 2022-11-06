<?php

namespace Core;

use Exception;

class Error
{
    public static function errorHandler(string $message, int $level, string $file, int $line): void
    {
        if(error_reporting() != 0){
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    public static function exceptionHandler($e): void
    {
        header('Content-Type: application/json; charset=utf-8', false, 500);

        echo json_encode([
            'exception message' => $e->getMessage(),
            'stack trace' => $e->getTraceAsString(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        
        die();
    }
}