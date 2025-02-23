<?php

namespace HTTP\Controllers;

abstract class Controller
{
    abstract public function index();
    abstract public function create();
    abstract public function store();
    abstract public function show();
    abstract public function update();
    abstract public function destroy();
}


