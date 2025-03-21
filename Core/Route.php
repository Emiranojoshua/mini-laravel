<?php

namespace Core;

use Core\Routing\Router;

class Route
{

    private static $instance;

    public static function __callStatic($method, $arguments)
    {
        if (!self::$instance) {
            self::$instance = new Router();
        }

        return self::$instance->$method(...$arguments);
    }
}
