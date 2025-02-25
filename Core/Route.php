<?php

namespace Core;

use Core\Middleware;

class Route
{
    public function __construct(
        public string $uri,
        public $controller,
        public string $method = 'get',
        private Middleware $middleware = Middleware::DEFAULT,
    ) {}

    public function setMiddleware(Middleware $middleware)
    {
        $this->middleware = $middleware;
    }

    public function getMiddleware(){
        return $this->middleware;
    }

}

