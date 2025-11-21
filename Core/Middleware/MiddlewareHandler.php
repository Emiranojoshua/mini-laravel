<?php

namespace Core\Middleware;

use Core\Exception\AuthException\AuthException;
use Core\Middleware;
use Core\Models\User;
use Core\Response;

final class MiddlewareHandler extends User
{


    public function __construct(
    ) {}

    public function init()
    {
        // $this->middleware = $middleware = new Middleware();
    }

    public function User()
    {
        return static::getUser();
    }

    public function handle(Middleware $middleware)
    {
        // dd($this->User());
        switch ($middleware) {
            case Middleware::GUEST:
                # code...
                // check if user is signed and return auth if....
                $this->Guest();
                break;

            case Middleware::AUTH:
                $this->Auth();
                break;

            default:
                $this->Default($middleware);
                // RequestErrorException::throwException("Invalid request", Response::BAD_REQUEST);
                break;
        }
    }

    private function Auth()
    {
        if ($this->User() == null) {
            return throw AuthException::ThrowException(errorCode: Response::UNAUTHORIZED, errorMessage: 'Your not authorized to view this page....');
        }
    }

    private function Guest()
    {
        // dd($this->user());
        if ($this->User() !== null) {
            return throw AuthException::ThrowException(errorCode: Response::UNAUTHORIZED, errorMessage: 'Your not authorized to view this page....');
        }
    }

    private function Default(Middleware $middleware) {}
}
