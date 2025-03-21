<?php

namespace Core\Auth;


class Auth
{

    private static $instance;

    public static function __callStatic($method, $args){
        if(!self::$instance){
            self::$instance = new Authentication;
        }

        return self::$instance->$method(...$args);
    }

}

