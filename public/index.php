<?php

declare(strict_types=1);

use Core\App\App;
use Core\Connection\Connection;
use Core\Container\Container;
use Core\Container\Provider;
use Dotenv\Dotenv;

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';
$functions = require BASE_PATH . "/../functions.php";
require BASE_PATH . '\..\routes\web.php';

$dotenv = Dotenv::createImmutable(BASE_PATH . '/../');
$dotenv->load();

//load container 
// $container = Container::load();


//use service container to bind classes

// $container->bind(App::class, App::class)->resolve();
// $container->bind(Dotenv::class, Dotenv::class)->resolve();
//container->load()

// Session::unflash();
// App::run();
// session_start();
App::getInstance()->run();


