<?php

namespace HTTP\Controllers;

use Core\ControllerTrait;

class HomeController extends Controller
{
  public function index() {
    return view("home");
  }
  public function create() {}
  public function store() {}
  public function show() {}
  public function update() {}
  public function destroy() {}
}
