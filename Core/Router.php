<?php

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

    public function dispatch(string $path , string $type): void
    {
        try {
            if(! $this->match($path, $type)){
                throw new \Exception('route not found', 404);
            }

            $controller = $this->convertToPascalCase($this->params['controller']);


            if(! class_exists($controller)){
                throw new \Exception('Controller class ' . $controller . ' not found.', 500);
            }

            $controllerObj = new $controller();
            $action = $this->params['action'];

            if(! is_callable([$controllerObj, $action])){
                throw new \Exception('Method ' . $action . ' not found in '. $controller, 500);
            }

            //$controllerObj->$action();

            header('Content-Type: application/json; charset=utf-8', false, 200);

            echo json_encode(['data' => $controllerObj->$action()]);

        } catch (Exception $e){
            header('Content-Type: application/json; charset=utf-8', false, $e->getCode());

            echo json_encode(['errorMessage' => $e->getMessage()]);
            exit();
        } 
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