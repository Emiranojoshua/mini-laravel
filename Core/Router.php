<?php

namespace Core;

use Core\Exception\RouterException\NotFoundException;
use Core\Exception\RouterException\RouterRuntimeException;
use Core\Response;

class Router extends Request
{

    public array  $request;

    public function __construct()
    {
        $this->request = $this->getRequest();

        // parent::__construct();
    }
    //handle the routing in the index page
    public function route()
    {
        $routes = $this->getRoutes();
        return Dispatch::dispatch($this->request, $routes);
    }
}
