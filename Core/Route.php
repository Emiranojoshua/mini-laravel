<?php

namespace Core;

use Core\Container\Container;
use Core\Routing\Router;

class Route
{
    private static function router(): Router
    {
        return Container::boot()->resolve(Router::class);
    }

    public static function __callStatic($method, $args)
    {
        return self::router()->$method(...$args);
    }
}