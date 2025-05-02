<?php

namespace Core\Exception;

use Core\Exception\AuthException\AuthException;
use Core\Exception\DatabaseException\DatabaseException;
use Core\Exception\RouterException\NotFoundException;
use Core\Exception\RouterException\RouterRuntimeException;
use Core\Response;

enum Exceptions: string
{
    case NOTFOUNDEXCEPTION = NotFoundException::class;

    case ROUTERRUNTIMEEXCEPTION =  RouterRuntimeException::class;
    case DATABASEEXCEPTION = DatabaseException::class;
    case AUTHEXCEPTION = AuthException::class;

    public function throw(string $message = ''): array
    {
        return match ($this) {
            self::NOTFOUNDEXCEPTION => self::notFoundException($message),

            self::ROUTERRUNTIMEEXCEPTION => [
                RouterRuntimeException::class,
                Response::SERVER_ERROR,
                empty($message) ? "RUNTIME EXCEPTION CAUGHT" : $message,
            ],

            self::DATABASEEXCEPTION => [
                DatabaseException::class,
                Response::SERVER_ERROR,
                empty($message) ? "SERVER ERROR" : $message,
            ],

            self::AUTHEXCEPTION => [
                AuthException::class,
                Response::UNAUTHORIZED,
                empty($message) ? "UNAHTHORIZED ACCESS" : $message,
            ],
        };
    }

    private function notFoundException($message): array
    {
        return [
            NotFoundException::class,
            Response::NOT_FOUND,
            empty($message) ? "PAGE NOT FOUND" : $message,
        ];
    }
}
exception(Exceptions::NOTFOUNDEXCEPTION->throw());
// exception(Exceptions::NOTFOUNDEXCEPTION(Response::NOT_FOUND, 'something went wronfg'));