<?php

namespace Core\Container;

class Container
{
    private static ?ContainerHandler $instance = null;

    final private function __construct() {}

    public static function boot(): ContainerHandler
    {
        if (!self::$instance) {
            self::$instance = new ContainerHandler;
        }

        return self::$instance;
    }
}
