<?php

namespace Core\Exception\RouterException;

use Core\Exception\RouterException\RouteException;
use Core\Response;

final class NotFoundException extends RouteException
{
    public function setError(): Response
    {
        return Response::NOT_FOUND;          
    }

    public function setErrorMessage(): string{
        return "A File Not Found Exception Occured";
    }
 
}
