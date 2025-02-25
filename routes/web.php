<?php

use Core\Router;
use HTTP\Controllers\HomeController;
use HTTP\Controllers\PostController;


$router->get('/home', function () {
    return view('home');
});
$router->get('/test', function () {
    return view('home');
});
$router->get('/contact', function () {
    return view('contact');
});
$router->get('/post', [PostController::class, 'index']);
