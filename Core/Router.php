<?php

namespace Core;

use Core\Exception\RouterException\NotFoundException;
use Core\Exception\RouterException\RouterRuntimeException;
use Core\Response;

class Router
{
    //array holding the routes
    public static array $routes = [];

    //route template 
    public static function add($route, $controller, $method = 'get'): array
    {
        return static::$routes[] = [
            "uri" => $route,
            "controller" => $controller,
            "method" => $method,
        ];
    }

    //handle get request
    public static function get(string $route, callable | array $controller): void
    {
        self::add($route, $controller);

        // return Router::class;
    }

    //handle post request
    public static function post(string $route, callable | array $controller): void
    {
        self::add($route, $controller, method: 'post');
    }
    public static function put(string $route, callable | array $controller): void
    {
        self::add($route, $controller, method: 'put');
    }
    public static function delete(string $route, callable | array $controller): void
    {
        self::add($route, $controller, method: 'delete');
    }

    //handle the routing in the index page
    public static function route($uri, $method)
    {

        $routes = self::getRoutes();
        $method = strtolower($method);
        foreach ($routes as $route) {
            if ($uri == $route['uri'] && $method == $route['method']) {
                // print_r($route['controller']);
                return Dispatch::dispatch($route['controller']);
            }
        }
        return throw NotFoundException::ThrowException('PAGE NOT FOUND', Response::NOT_FOUND);
    }



    //getting the  routes
    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
