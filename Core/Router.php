<?php

namespace Core;

use Exception;
use Core\Response;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add(string $type, string $route, array $params): void
    {
        $this->routes[$type][$route] = $params;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(string $path, string $type): bool
    {
        if(array_key_exists($path, $this->routes)){
            if(array_key_exists($type, $this->routes[$path])){
                $this->params = $this->routes[$path][$type];
                return true;
            }
        }

        return false;
    }

    public function dispatch(string $path , string $type, ?object $data): void
    {
        try {
            if(! $this->match($path, $type)){
                throw new \Exception('route not found', 404);
            }
        } catch (Exception $e) {
            Response::response($e->getCode(), ["errorMessage" => $e->getMessage()]);
        }

        $controller = 'App\Controllers\\' .$this->convertToPascalCase($this->params['controller']);

        if(! class_exists($controller)){
            throw new \Exception('Controller class ' . $controller . ' not found.');
        }

        $controllerObj = new $controller($data);
        $action = $this->params['action'];

        if(! is_callable([$controllerObj, $action])){
            throw new \Exception('Method ' . $action . ' not found in '. $controller);
        }

        header('Content-Type: application/json; charset=utf-8', false, 200);

        echo json_encode(['data' => $controllerObj->$action()]); 
    }

    public function getParams(): array
    {
        return $this->params;
    }

    private function convertToPascalCase(string $value): string
    {
        return str_replace(' ', '', \ucwords(\str_replace(['-', '_'], ' ', $value)));
    }
}