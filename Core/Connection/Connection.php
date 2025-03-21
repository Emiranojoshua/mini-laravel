<?php 

namespace Core\Connection;

class Connection{
    private static $connection;

    public static function __callStatic($method, $args){
        if(!self::$connection){
            self::$connection = new ConnectionHandler();
        
        }
        return self::$connection->$method(...$args);
    }
}