<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Request\Request;
use Core\Validation\Validator;

final class HomeController
{
  public function index(string $name = 'SOMETHING')
  {
    return view("home");
  }
  public function create(Request $request, Auth $auth)
  {
    
    $request->validate([
      'email' => ['required', 'email', 'min:5'],
      'password' => ['required', 'min:6'],
    ]);
    $auth::create();
    $auth::login();
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {} 
}
