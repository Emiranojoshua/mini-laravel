<?php

namespace HTTP\Controllers;

use Core\Auth\AuthService;
use Core\Models\User;
use Core\Request\Request;

final class WelcomeController
{
  public function index(string $name)
  {
    return view("welcome");
    
  }
  public function create(Request $request, AuthService $auth, User $userModel): void
  {
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
