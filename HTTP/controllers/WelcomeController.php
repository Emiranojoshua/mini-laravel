<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Models\User;
use Core\Request\Request;

final class WelcomeController
{
  public function index(string $name = 'SOMETHING')
  {
    return view("welcome");
  }
  public function create(Request $request, Auth $auth, User $userModel): void
  {
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
