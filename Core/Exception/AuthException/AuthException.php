<?php

namespace Core\Exception\AuthException;

use Core\Exception\Foundation\BaseException;
use Core\Response;

final class AuthException extends BaseException {
    public function setError(): Response
    {
        return Response::REDIRECT;          
    }

    public function setErrorMessage(): string{
        return "An auth exception occured";
    }
}
