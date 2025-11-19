<?php

namespace Core;

use Core\Routing\Router;

class RouteFacade
{

    private static $instance;

    public static function __callStatic($method, $arguments)
    {
        if (!self::$instance) {
            self::$instance = new Router();
        }

        // dc([$method, $arguments]);

        return self::$instance->$method(...$arguments);
    }
}
