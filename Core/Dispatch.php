<?php

namespace Core;

use Core\Exception\RouterException\RouterRuntimeException;
use HTTP\Controllers\Controller;

class Dispatch
{
    public static function dispatch($controller)
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

    public static function dispatchMethod($controller)
    {

        // echo view('home');
        echo call_user_func($controller);
        exit();
    }

    public static function dispatchController($controller)
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


        $instance = new $controller();

        return  $instance->$method();
    }
}
