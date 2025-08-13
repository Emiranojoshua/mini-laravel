<?php

namespace Core\Container;

use Core\Connection\Connection;
use Exception;

class Container
{
    private static $instance = null;

    public static function __callStatic($method,  $args)
    {
        if (self::$instance == null) {
            self::$instance = new ContainerHandler;
        }
        // dd($args);
        if (count($args) > 2) {
            throw new Exception("resolver required 1 argument " . count($args) . " passed");
        }

        

        if (count($args) > 1) {
            # code...
            [$class, $classMethod] = $args;
            return self::$instance->$method($class, $classMethod);
        } else {
            [$class] = $args;
            return self::$instance->$method($class);
        }

        //usage 
        //$method -> method call from container class
        // $args -> parameters for the methods in the container class

    }
}
