<?php

namespace Core\Exception\RouterException;

use Core\Response;

final class RouterRuntimeException extends RouteException {
    public function setError(): Response
    {
        return Response::SERVER_ERROR;          
    }
    public function getErrorMessage(): string
    {
        return 'Something went wrong...';
    }
}
