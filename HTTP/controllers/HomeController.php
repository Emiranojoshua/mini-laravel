<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Models\User;
use Core\Request\Request;

final class HomeController
{
  public function index(string $name = 'SOMETHING')
  {
    return view("login");
  }
  public function create(Request $request, Auth $auth, User $userModel): void
  {
    $attr = $request->validate([
      'email' => ['required', 'email', 'min:5'],
      'password' => ['required', 'min:6'],
    ]);

    //check if table exist
    //create table if not exist
    //insert fields to table based on what is here
    //but if we use this then the table is created with just these 
    //create the table by developer seems legitly better 
    //but if table not created have option of create table
    $user = $userModel->create($attr);
    if ($auth->login($attr)) {
      header("Location: welcome");
      exit();
      view("welcome", ["user" => $auth->user()]);
      exit();
    };
    // return redirect();    
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
