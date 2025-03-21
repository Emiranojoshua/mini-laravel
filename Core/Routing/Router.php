<?php

namespace Core\Routing;

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
