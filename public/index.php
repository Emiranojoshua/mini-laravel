<?php

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';

use Core\Router;


$functions = require BASE_PATH . "/../functions.php";
base_path(path: '/../routes/web.php');


$uri = parse_url($_SERVER['REQUEST_URI'])['path'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];



try {
    Router::route($uri, $method);
} catch (Exception $th) {
    $errorCode = method_exists($th, 'getErrorCode') ? get_class($th)::getErrorCode()  : 500;
    $errorMessage = method_exists($th, 'getErrorMessage') ? get_class($th)::getErrorMessage()  : "Internal Server Error";

    //return http status code
    http_response_code($errorCode);

    // dd([$errorCode, $errorMessage]);

    //render error page
    return renderError([
        'errorCode' => $errorCode,
        'errorMessage' => $errorMessage
    ]);
}
