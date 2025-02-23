<?php

namespace Core;

use Core\Middleware;

class Route
{
    public function __construct(
        public string $uri,
        public string $controller,
        public string $method = 'get',
        private Middleware $middleware = Middleware::DEFAULT,
    ) {}

    public function middleware(Middleware $middleware)
    {
        $this->middleware = $middleware;
    }

    public function getMiddleware(){
        return $this->middleware;
    }
}

// (new Route('/home', ''))->middleware(Middleware::GUEST);
