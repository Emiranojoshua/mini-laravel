<?php

declare(strict_types=1);

use Core\App\App;

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';
$functions = require BASE_PATH . "/../functions.php";
require BASE_PATH . '\..\routes\web.php';

App::run();
