<?php

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';

use Core\Router;
use Core\Exception\RouteException;


$functions = require BASE_PATH . "/../functions.php";
base_path(path: '/../web/routes.php');


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];


$exception = new RouteException;

try {
    Router::route($uri, $method);
} catch (RouteException $th) {
    return view('404');
} catch (Exception $th) {
    return view('error');
}
