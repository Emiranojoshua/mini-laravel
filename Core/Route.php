<?php

namespace Core;

use Core\Routing\Router;

class Route
{

    private static $instance;

    public static function __callStatic($name, $arguments)
    {
        if (!self::$instance) {
            self::$instance = new Router();
        }

        return self::$instance->$name(...$arguments);
    }
}
