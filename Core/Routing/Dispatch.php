<?php

namespace Core\Routing;

use Core\Auth\Auth;
use Core\Container\Container;
use Core\Container\ContainerHandler;
use Core\Exception\Exceptions;
use Core\Exception\RouterException\NotFoundException;
use Core\Exception\RouterException\RouterRuntimeException;
use Core\Middleware\MiddlewareHandler;
use Core\Request\Request;
use Core\Response;

class Dispatch
{
    public static function dispatch(array $request, array $routes)
    {
        [$uri, $method] = $request;
        $method = strtolower($method);
        foreach ($routes as $route) {
            if ($uri == $route->uri && $method == $route->method) {
                // print_r($route['controller']);
                // dd('route fond');
                (new MiddlewareHandler($route->middleware))->handle();

                // Middlewarehandler::handle($route->middleware);
                return static::dispatchRoute($route->controller);
            }
        }
        // return throw NotFoundException::ThrowException(
        //     Response::NOT_FOUND,
        //     "PAGE NOT FOUND"
        // );

        // dd(Exception(Exceptions::NOTFOUNDEXCEPTION->throw()));
        return Exception(Exceptions::NOTFOUNDEXCEPTION->throw());
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
        return throw RouterRuntimeException::ThrowException(
            Response::BAD_REQUEST,
            "INVALID CONTROLLER PARAMETER SET"
        );
    }

    public static function dispatchMethod(callable $controller)
    {

        // echo view('home');
        echo call_user_func($controller);
        exit();
    }

    public static function dispatchController(array $controller)
    {
        [$controller, $method] = $controller;
        if (!class_exists($controller)) {
            throw RouterRuntimeException::ThrowException(
                Response::BAD_REQUEST,
                "Controller $controller not found",
            );
        }
        if (!method_exists($controller, $method)) {
            throw RouterRuntimeException::ThrowException(
                Response::BAD_REQUEST,
                "Method $method not found in $controller"
            );
        }


        $dependencies = Container::resolveMethod($controller, $method);

        return (new $controller())->$method(...$dependencies);

        // return  $instance->$method();
    }
}
