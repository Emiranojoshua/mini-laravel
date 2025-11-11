<?php

namespace Core\Middleware;

use Core\Exception\AuthException\AuthException;
use Core\Exception\ServerException\RequestErrorException;
use Core\Middleware;
use Core\Models\DTOs\UserEntity;
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
                $this->Guest($this->middleware);
                break;

            case Middleware::AUTH:
                $this->Auth($this->middleware);
                break;

            default:
                $this->Default($this->middleware);
                // RequestErrorException::throwException("Invalid request", Response::BAD_REQUEST);
                break;
        }
    }

    private function Auth(Middleware $middleware)
    {
        dd($middleware);
        if ($this->User() ==- null) {
            return throw AuthException::ThrowException(errorCode: Response::UNAUTHORIZED, errorMessage: 'Your not authorized to view this page....');
        }
    }

    private function Guest(Middleware $middleware)
    {
        // dd($this->user());
            if ($this->User() !== null) {
            return throw AuthException::ThrowException(errorCode: Response::UNAUTHORIZED, errorMessage: 'Your not authorized to view this page....');
        }
    }

    private function Default(Middleware $middleware) {}
}
