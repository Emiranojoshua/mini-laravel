<?php
namespace Core;
use Core\Exception\RouteException;
use Exception;


class Router
{

    public static array $routes = [];

    public static function add($route, $controller, $method = 'get'): array
    {
        return static::$routes[] = [
            "uri" => $route,
            "controller" => $controller,
            "method" => $method,
        ];
    }


    public static function get(string $route, $controller): void
    {
        self::add($route, $controller);
    }
    public static function post(string $route, $controller): void
    {
        self::add($route, $controller, method: 'post');
    }

    public static function route($uri, $method)
    {

        // dd('this is called');
        //get all the routes
        $routes = self::getRoutes();
        // dd($routes);
        $method = strtolower($method);
        //check if the uri matches the route and the method
        foreach ($routes as $route) {
            if($uri == $route['uri'] && strtolower($method) == $route['method']){
                $path = $route['controller'];
                view($path);
                exit();
            }

        }
        throw new RouteException('route not found');
        //if it matches require that file 
        //if no match is found throw an exception
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
