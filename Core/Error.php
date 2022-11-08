<?php

namespace Core;

class Error
{
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