<?php

use Core\Middleware;
use Core\Route;
use Core\Routing\Router;

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';
$functions = require BASE_PATH . "/../functions.php";


// $router = new Router();
// $router->get('/home', function () {
//     return view('home');
// })->middleware(Middleware::AUTH);
// $router->get('/post', function () {
//     return view('posts');
// })->middleware(Middleware::AUTH);
// $router->get('/contact', function () {
//     return view('contact');
// })->middleware(Middleware::AUTH);
// $router->get("/", function () {
//     return view('home');
// })->middleware(Middleware::GUEST);
// $router->get("/new route", function () {
//     return view('home');
// });


require BASE_PATH . '\..\routes\web.php';


try {
    Route::route();
    // $router->route();
    // $router->route();=]]]   Route::route();00 ]- 

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
