<?php

namespace Core\Exception\DatabaseException;

use Core\Exception\Foundation\BaseException;
use Core\Response;

final class DatabaseException extends BaseException {
    public function getErrorCode(): int|Response
    {
        return Response::SERVER_ERROR;          
    }
    public function getErrorName(): string
    {
        return 'Internal Server Error';
    }
    public function getErrorMessage(): string
    {
        return 'Something went wrong...';
    }
}
