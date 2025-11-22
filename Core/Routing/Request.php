<?php

namespace Core\Routing;

use Core\Middleware;

abstract class Request
{
    private array  $routes = [];

    private function add($route, $controller, $method)
    {
        $this->routes[] = new RouteInstance($route, $controller, $method);
        return $this;
    }

    public function get(string $route, callable | array $controller)
    {
        return $this->add(route: $route, controller: $controller, method: 'get');

    }
    public function post(string $route, callable | array $controller)
    {
        return $this->add(route: $route, controller: $controller, method: 'post');
    }
    public function put(string $route, callable | array $controller)
    {
        return $this->add(route: $route, controller: $controller, method: 'put');
    }
    public function delete(string $route, callable | array $controller)
    {
        return $this->add(route: $route, controller: $controller, method: 'delete');
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }


    public function middleware(Middleware $middleware)
    {
        $this->routes[array_key_last($this->routes)]->middleware = $middleware;
        return $this;
    }
}
