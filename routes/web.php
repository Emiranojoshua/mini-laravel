<?php

use Core\Router;
use HTTP\Controllers\HomeController;
use HTTP\Controllers\PostController;


Router::get('/home', function () {
    return view('home');
});

Router::get('/', function () {
    return view('home');
});

Router::get(
    '/test',
    [PostController::class, 'index']
);

Router::get(
    '/contact',
    [PostController::class, 'create']
);
Router::get(
    '/',
    [HomeController::class, 'index']
);
Router::get(
    '/post',
    [PostController::class, 'index']
);
Router::post(
    '/post',
    [PostController::class, 'index']
);
