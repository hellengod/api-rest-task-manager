<?php

namespace App\Http;

class Router
{
    private $routes = [];

    private function addRoute($method, $path, $action)
    {
        $this->routes[$method][$path] = $action;
    }

    public function get($path, $action)
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post($path, $action)
    {
        $this->addRoute('POST', $path, $action);
    }

    public function put($path, $action)
    {
        $this->addRoute('PUT', $path, $action);
    }

    public function delete($path, $action)
    {
        $this->addRoute('DELETE', $path, $action);
    }

    public function patch($path, $action)
    {
        $this->addRoute('PATCH', $path, $action);
    }
}