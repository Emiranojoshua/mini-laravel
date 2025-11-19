<?php

namespace Core\Container;

use Core\App\App;
use Core\Connection\Connection;
use Core\Routing\Router;

class Provider extends ServiceProvider
{
    protected function register()
    {
        //register services here
        $this->container->singleton(Connection::class, Connection::class);
        $this->container->singleton(
            Router::class,
            Router::class
        );
    }
}
