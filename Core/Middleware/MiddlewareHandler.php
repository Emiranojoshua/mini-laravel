<?php

namespace Core\Middleware;

use Core\Exception\AuthException\AuthException;
use Core\Middleware;
use Core\Models\User;
use Core\Response;

final class MiddlewareHandler extends User
{
    // public Middleware $middleware;

    public function __construct(
        public Middleware $middleware,
        // private AuthInterface $authProvider
    ) {}

    public function User()
    {
        return $this->getUser();
    }

    public function handle()
    {
        switch ($this->middleware) {
            case Middleware::GUEST:
                # code...
                // check if user is signed and return auth if....
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
        dd($this->User());
        // $this->authProvider->user();
        return throw AuthException::ThrowException(errorCode: Response::UNAUTHORIZED, errorMessage: 'Your not authorized to view this page....');
    }

    private function Guest(Middleware $middleware) {}
}
