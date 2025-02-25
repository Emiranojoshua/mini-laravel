<?php

namespace Core;

use Core\Exception\RouterException\NotFoundException;
use HTTP\Controllers\PostController;


abstract class Request
{
    private array  $routes = [];
    public array $request;

    public function __construct()
    {
        $this->request = $this->getRequest();
        return;
    }


    private function add($route, $controller, $method)
    {
        $this->routes[] = new Route($route, $controller, $method);
    }

    public function get(string $route, callable | array $controller)
    {
        $this->add(route: $route, controller: $controller, method: 'get');
        return $this;
    }
    public function post(string $route, callable | array $controller)
    {
        $this->add(route: $route, controller: $controller, method: 'post');
        return $this;
    }
    public function put(string $route, callable | array $controller)
    {
        $this->add(route: $route, controller: $controller, method: 'put');
        return $this;
    }
    public function delete(string $route, callable | array $controller)
    {
        $this->add(route: $route, controller: $controller, method: 'delete');
        return $this;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }


    public function getRequest(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        return [$uri, $method];
    }
}
