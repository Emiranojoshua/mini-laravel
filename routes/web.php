<?php

use Core\Middleware;
use Core\Route;
use HTTP\Controllers\HomeController;


Route::get('/', function () {
    return view('home');
})->middleware(Middleware::GUEST);

Route::get('/home', function () {
    return view('/home');
})->middleware(Middleware::GUEST);

Route::get(
    '/contact',
    function () {
        return view('contact');
    }
)->middleware(Middleware::GUEST);

Route::get('/post', function () {
    return view('posts');
})->middleware(Middleware::GUEST);

Route::post('/post', function () {
    return view('posts');
})->middleware(Middleware::AUTH);

Route::get(
    '/login',
    [HomeController::class, 'index']
)->middleware(Middleware::GUEST);

Route::post(
    '/login',
    [HomeController::class, 'create']
)->middleware(Middleware::GUEST);



//creting a welcome controller to disiplay a single page
//just returning the view 
Route::get('/welcome', function(){
   return view("welcome");
})->Middleware(Middleware::GUEST);

Route::get(
    '/welcome',
    [HomeController::class, 'create']
)->middleware(Middleware::GUEST);
