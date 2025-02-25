<?php

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';
$functions = require BASE_PATH . "/../functions.php";


use Core\Router;

$router = new Router();


require BASE_PATH . '\..\routes\web.php';





// $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// // dd($uri);
// $method = $_SERVER['REQUEST_METHOD'];

// dd(Router::get('/', function(){
//     return 'called from index page';
// }));

try {
    // Router::route($uri, $method);
    $router->route();

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
