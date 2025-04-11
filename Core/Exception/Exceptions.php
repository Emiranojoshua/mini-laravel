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

    public function throw(): array
    {
        return match ($this) {
            self::NOTFOUNDEXCEPTION => self::notFoundException(),

            self::ROUTERRUNTIMEEXCEPTION => [
                RouterRuntimeException::class,
                Response::SERVER_ERROR,
                "PAGE NOT FOUN"
            ],

            self::DATABASEEXCEPTION => [
                DatabaseException::class,
                Response::SERVER_ERROR,
                "PAGE NOT FOUN"
            ],

            self::AUTHEXCEPTION => [
                AuthException::class,
                Response::UNAUTHORIZED,
                "PAGE NOT FOUN"
            ],
        };
    }

    private function notFoundException(): array
    {
        return [
            NotFoundException::class,
            Response::NOT_FOUND,
            "PAGE NOT FOUND",
        ];
    }
}
