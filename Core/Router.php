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
            "middleware" => [],
        ];

        // return static::$routes[] = new Route($route, $controller, $method);
        //route = new Route(...);
        //$routes[] = $route;
        //return $route;

        //now the $route->middleware <-- which is chainable
    }

    //handle get request
    public static function get(string $route, callable | array $controller)
    {
        self::add($route, $controller);

        return new static;

        // return Router::class;
    }

    //handle post request
    public static function post(string $route, callable | array $controller): self
    {
        self::add($route, $controller, method: 'post');

        return new static;
    }
    public static function put(string $route, callable | array $controller): self
    {
        self::add($route, $controller, method: 'put');

        return new static;
    }
    public static function delete(string $route, callable | array $controller): self
    {
        self::add($route, $controller, method: 'delete');

        return new static;
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
        return throw NotFoundException::ThrowException(
            Response::NOT_FOUND,
            "PAGE NOT FOUND"
        );
    }



    //getting the  routes
    public static function getRoutes(): array
    {
        return self::$routes;
    }
}


class TestRouter
{

    public function __constructor() {}
}
