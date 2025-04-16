<?php

namespace Core\Auth;

use Core\Connection\Connection;
use Core\Exception\AuthException\AuthException;
use Core\Exception\Exceptions;
use Core\Models\Model;
use Core\Request\Request;

class Auth
{

    public function authenticate() {}

    public function user()
    {
        return 'user returned';
        //get user from session 
        //session already store user data
        //needes session construction that constructors session data 
    }


    public function create(array $attributes): void
    {
        //check if user exist
        //perform validation
        //signup user
        if (empty($attributes)) {
            exception(Exceptions::AUTHEXCEPTION->throw("Empty attributes passed"));
        }


        //read
        //write
        //update
        //delete
        //secondaty ----
        //join


    }

    public function login(Model $model)
    {

        dd($model->attributes);
        //user should be a class of its own 

        (new Request())->only(['email', 'password', 'sometinger']);

        if (empty($args)) {
            $query =  "SELECT * FROM USERS where email = :email AND  password = :password";
        }
    }
    public function logout() {}
    public function verify($username, $password) {}
    public function check($username, $password) {}
}
