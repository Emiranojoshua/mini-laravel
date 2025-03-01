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
                $user = null;
                if (!$user) {
                    return throw AuthException::ThrowException(Response::UNAUTHORIZED, 'your not authorized to view this page');
                }
                // break;

            default:
                # code...
                break;
        }
    }
}
