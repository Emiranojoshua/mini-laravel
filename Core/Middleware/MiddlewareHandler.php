<?php

namespace Core\Middleware;

use Core\Exception\AuthException\AuthException;
use Core\Middleware;
use Core\Response;

class MiddlewareHandler
{
    // public Middleware $middleware;

    public function __construct(public Middleware $middleware) {}

    public function handle()
    {
        switch ($this->middleware) {
            case Middleware::GUEST:
                # code...
                break;

            case Middleware::AUTH:
                $this->Auth($this->middleware);
                break;

            default:
                # code...
                break;
        }
    }

    private function Auth(Middleware $middleware)
    {
        return throw AuthException::ThrowException(errorCode: Response::UNAUTHORIZED, errorMessage: 'Your not authorized to view this page....');
    }

    private function Guest(Middleware $middleware) {}
}
