<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Models\UserModel;
use Core\Request\Request;
use Core\Routing\Router;
use Core\Validation\Validator;

final class HomeController
{
  public function index(string $name = 'SOMETHING')
  {    
    return view("login");
  }
  public function create(Request $request, Auth $auth, UserModel $userModel)
  {
    
    $attr = $request->validate([
      'email' => ['required', 'email', 'min:5'],
      'password' => ['required', 'min:6'],
    ]);

    
    $authUser = $userModel->create($attr);



    // dd($_SESSION);
    // $auth::create();
    $auth->login($authUser);
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
