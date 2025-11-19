<?php

namespace Core\Routing;

use Core\Container\Container;
use Core\Exception\RouterException\NotFoundException;
use Core\Exception\RouterException\RouterRuntimeException;
use Core\Middleware\MiddlewareHandler;
use Core\Response;

final class Dispatch
{
    public static function dispatch(array $request, array $routes)
    {
        // [$uri, $method] = $request;
        $uri = $request['uri'];
        $method = strtolower($request['method']);
        $url =  $request['requestData']['HTTP_HOST'] . $uri;
        foreach ($routes as $route) {
            if ($uri == $route->uri && $method == $route->method) {
                // print_r($route['controller']);
                // dd('route fond');
                // dd([$route->middleware, $route->controller, $route->uri, $route->method]);
                (new MiddlewareHandler($route->middleware))->handle();

                // Middlewarehandler::handle($route->middleware);
                return static::dispatchRoute($route->controller);
            }
        }

        return throw NotFoundException::throwException(
            "The Requested Page $url does not exist or wasn't found...",
            Response::NOT_FOUND
        );
    }

    public static function dispatchRoute(array | callable $controller)
    {
        if (is_array($controller) && count($controller) === 2) {
            return self::dispatchController($controller);
        }

        if (is_callable($controller)) {

            return self::dispatchmethod($controller);
        }
        // dd('this was reached');
        return throw RouterRuntimeException::throwException(
            "INVALID CONTROLLER PARAMETER SET",
            Response::BAD_REQUEST
        );
    }

    public static function dispatchMethod(callable $controller)
    {

        // echo view('home');

        echo call_user_func($controller);
        return;
    }

    public static function dispatchController(array $controller)
    {
        [$controller, $method] = $controller;
        if (!class_exists($controller)) {

            return throw RouterRuntimeException::throwException(
                "Controller $controller not found",
                Response::BAD_REQUEST
            );
        }
        if (!method_exists($controller, $method)) {
            return throw RouterRuntimeException::throwException(
                "Method $method not found in $controller",
                Response::BAD_REQUEST
            );
        }


        Container::call($controller, $method);
    }
}
