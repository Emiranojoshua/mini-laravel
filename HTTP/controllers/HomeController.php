<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Models\User;
use Core\Request\Request;
use Core\Response;

final class HomeController
{
  public function index(Request $request)
  {
    return view("login");
  }
  public function create(Request $request, Auth $auth, User $userModel)
  {

    $attr = $request->validate([
      'email' => ['required', 'email', 'min:5'],
      'password' => ['required', 'min:6'],
    ]);

    if ($attr["status"] === "failed") {
      session_flash($attr['errors']);
      session_old($attr['formData']);
      return view('/login');
    }

    //check if table exist
    //create table if not exist
    //insert fields to table based on what is here
    //but if we use this then the table is created with just these 
    //create the table by developer seems legitly better 
    //but if table not created have option of create table
    $user = $userModel->create($attr);
    
    if ($auth->login($attr)) {
      redirect("/welcome", Response::OK)->to();
    };
    // return redirect();    
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
