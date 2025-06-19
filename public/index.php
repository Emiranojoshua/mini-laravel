<?php

declare(strict_types=1);

use Core\App\App;
use Core\Session\Session;

const BASE_PATH = __DIR__;
require BASE_PATH . '/../vendor/autoload.php';
$functions = require BASE_PATH . "/../functions.php";
require BASE_PATH . '\..\routes\web.php';

// Session::unflash();
// App::run();
// session_start();
App::getInstance()->run();



class Mother
{
    public function a()
    {
        return;
    }
    public function b()
    {
        return;
    }
    public function c()
    {
        return;
    }
}

class Father extends Mother
{
    public function abc()
    {
        return;
    }
}

class Child extends Father{
    public function emm( ): void
    {
        return;
    }
}

(new Child)->b();
