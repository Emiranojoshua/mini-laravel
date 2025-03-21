<?php

namespace HTTP\Controllers;

final class PostController extends Controller
{

    public function index() {
        return view("posts");
    }
    public function create() {
        return view('contact');
    }
    public function store() {}
    public function show() {}
    public function update() {}
    public function destroy() {}
}
