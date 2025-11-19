<?php

namespace Core\Routing;

use Core\Request\Request as Response;
use Core\Routing\Request;

class Router extends Request
{

    public function route()
    {
        return Dispatch::dispatch(
            [
                "method" => Response::getRequestMethod(),
                "uri" => Response::getRequestUri(),
                "requestData" => Response::getRequest()
            ],
            $this->getRoutes(),
        );
    }
}
