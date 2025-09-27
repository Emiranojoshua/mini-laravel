<?php

namespace HTTP\Controllers;

use Core\Auth\Auth;
use Core\Auth\AuthService;
use Core\Models\User;
use Core\Request\Request;

final class HomeController
{
  public function index()
  {
    return view("login");
  }
  public function create(Request $request, AuthService $auth, User $userModel)
  {

    $attr = $request->validate([
      'email' => ['required', 'email', 'min:5'],
      'password' => ['required', 'min:6'],
    ]);

    if ($attr == null) {
      session_flash($request->getResponse("errors"));
      session_old($request->getResponse("formData"));
      return view('login');
    }

    $user = $userModel->create($attr);

    // dc($userModel->getResponse("errors"));

    if ($user == null) {
      session_flash($userModel->getResponse("errors"));
      session_old($userModel->getResponse("formData"));
      return view('login');
    }

    if ($auth->login($attr) == null) {
      session_flash($auth->getResponse("errors"));
      session_old($auth->getResponse("formData"));
      return view('login');
    };

    return view("welcome");

    // return redirect();
  }
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
