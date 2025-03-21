<?php

namespace HTTP\Controllers;

use Core\Request\Request;

abstract class Controller
{
    abstract public function index();
    abstract public function create();
    abstract public function store();
    abstract public function show();
    abstract public function update();
    abstract public function destroy();
}


