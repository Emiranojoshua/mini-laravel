<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Connection\Connection;
use Core\Connection\ConnectionHandler;
use Core\ControllerTrait;
use Core\Request\Request;

final class HomeController 
{
  public function index(string $name = 'SOMETHING')
  {
    return view("home");
  }
  public function create(Request $request, Auth $auth)
  {

    dd($request->all());
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
