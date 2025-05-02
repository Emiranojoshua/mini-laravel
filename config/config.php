<?php

namespace Config;

use PDO;

class Config
{

    public static function database()
    {
        return
            [
                "database" => [
                    'mysql' => [
                        'driver' => 'mysql',
                        'host' => 'localhost',
                        'port' => 8888,
                        'username' => "root",
                        'database' => 'emirano',
                        'password' => "",
                        'options' => [
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        ],
                    ]
                ]
            ];
    }
}
