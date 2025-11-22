<?php

declare(strict_types=1);

use Core\App\App;
use Core\Container\Container;
use Dotenv\Dotenv;

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';
$functions = require BASE_PATH . "/../functions.php";

$dotenv = Dotenv::createImmutable(BASE_PATH . '/../');
$dotenv->load();

Container::boot();

App::getInstance()->run();
