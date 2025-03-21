<?php 

namespace Core\Container;

use Exception;

class Container
{
    private static $instance = null;

    public static function __callStatic($method,  $args)
    {
        if (self::$instance == null) {
            self::$instance = new ContainerHandler;
        }

        if (count($args) > 2) {
            throw new Exception("resolver required 1 argument " . count($args) . " passed");
        }

        [$class, $dependencies] = $args;


        return self::$instance->$method($class, $dependencies);
    }

    public static function loop(array $args)
    {
        foreach ($args as $arg) {
            return $arg;
        }
    }
}