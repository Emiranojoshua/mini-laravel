<?php

use Core\Router;
use HTTP\Controllers\HomeController;
use HTTP\Controllers\PostController;




Router::get('/home', function () {
    return 'this is not a callback';
});
Router::get('/test', function () {
    return view('home');
});
Router::get('/contact', []);
Router::get('/', [HomeController::class, 'index']);
Router::get('/posts', [PostController::class, 'index']);
