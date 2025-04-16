<?php

namespace Core\Session;

class SessionHandler
{

    private static $session;

    public static function __callStatic($method, $args)
    {
        if (!self::$session) {
            self::$session = new Session;
        }

        return self::$session->$method(...$args);
    }
}
