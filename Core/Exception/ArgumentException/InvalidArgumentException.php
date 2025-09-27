<?php

namespace Core\Exception\ArgumentException;

use Core\Exception\Foundation\BaseException;
use Core\Response;

final class InvalidArgumentException extends BaseException {
    public function setError(): Response
    {
        return Response::METHOD_NOT_ALLOWED;          
    }

    public function setErrorMessage(): string{
        return "Invalid Argument";
    }
}
