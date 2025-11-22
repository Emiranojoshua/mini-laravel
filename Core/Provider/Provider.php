<?php

namespace Core\Provider;

use Core\Connection\Connection;
use Core\Exception\Foundation\ExceptionDetails;
use Core\Middleware\MiddlewareHandler;
use Core\Routing\Router;

class Provider extends ServiceProvider
{
    protected function register()
    {
        //register services here
        $this->singleton(Connection::class, Connection::class);
        $this->singleton(
            Router::class,
            Router::class
        );
        $this->bind(MiddlewareHandler::class, MiddlewareHandler::class);
        $this->bind(ExceptionDetails::class, ExceptionDetails::class);
    }
}
