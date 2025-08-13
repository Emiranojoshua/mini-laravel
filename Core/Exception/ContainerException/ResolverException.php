<?php 

namespace Core\Exception\ContainerException;

use Core\Exception\Foundation\BaseException;
use Core\Response;

final class ResolverException extends BaseException {
    public function setError(): Response
    {
        return Response::BAD_REQUEST;          
    }

    public function setErrorMessage(): string{
        return "Class passed is not a valid class";
    }
}