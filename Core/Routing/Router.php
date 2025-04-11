<?php

namespace Core\Routing;

use Core\Exception\ExceptionHandler;
use Core\Exception\RouterException\NotFoundException;
use Core\Exception\TestException;
use Core\Response;

class Router extends Request
{

    public array  $request;

    public function __construct()
    {
        $this->request = $this->getRequest();
    }
    //handle the routing in the index page
    public function route()
    {
        return Dispatch::dispatch(
            $this->request,
            $this->getRoutes(),
        );
    }
}
