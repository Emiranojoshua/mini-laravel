<?php

use Core\Middleware;
use Core\Route;
use HTTP\Controllers\HomeController;
use HTTP\Controllers\PostController;


// Route::get('/home', function () {
//     return view('home');
// });
// // $router->get('/home', function () {
// //     return view('home');
// // })->middleware();
// // $router->get('/contact', function () {
// //     return view('contact');
// // });
// // $router->get('/post', function () {
// //     return view('posts');
// // });
// // $router->get('/', function () {
// //     return view('home');
// // });
// Route::get('/', function () {
//     return view('home');
// });
// Route::get('/test', function () {
//     return view('home');
// })->middleware();
// Route::get('/contact', function () {
//     return view('contact');
// });
// Route::get('/post', [PostController::class, 'index']);
// Route::post('/post', [PostController::class,'create']);

Route::get('/', function () {
    return view('home');
})->middleware(Middleware::AUTH);
Route::get(
    '/home',
    [HomeController::class, 'index']
)->middleware(Middleware::GUEST);

Route::get(
    '/contact',
    function () {
        return view('contact');
    }
)->middleware(Middleware::GUEST);

Route::get('/post', function () {
    return view('posts');
})->middleware(Middleware::GUEST);
