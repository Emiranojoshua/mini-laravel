<?php

namespace Core\Session;

class Session
{

    private static $session;

    public static function __callStatic($method, $args)
    {
        if (!self::$session) {
            self::$session = new SessionHandler;
        }

        return self::$session->$method(...$args);
    }
}
