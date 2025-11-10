<?php

namespace Core\Routing;

use Core\Middleware;

class RouteInstance
{
    public function __construct(
        public string $uri,
        public $controller,
        public string $method = 'get',
        public Middleware $middleware = Middleware::AUTH,
    ) {}
}

