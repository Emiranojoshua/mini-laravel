<?php

use Core\Router;

Router::get('/', 'home');
Router::get('/contact', 'contact');
Router::get('/home', 'home');
Router::post('/sessions', 'sessions');

