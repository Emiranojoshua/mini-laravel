<?php

namespace Core\Exception\AuthException;

use Core\Exception\Foundation\BaseException;
use Core\Response;

final class UserNotFoundAuthException extends BaseException {
    public function setError(): Response
    {
        return Response::BAD_REQUEST;          
    }

    public function setErrorMessage(): string{
        return "User not found";
    }
}
