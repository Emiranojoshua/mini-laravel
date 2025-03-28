<?php

namespace Core\Auth;

use Core\Connection\Connection;
use Core\Request\Request;

class Authentication
{

    public function authenticate() {}

    public function user()
    {
        return 'user returned';
        //get user from session 
        //session already store user data
        //needes session construction that constructors session data 
    }

    public function create(array $args): void
    {
        //check if user exist
        //perform validation
        //signup user


    }

    public static function login(array $args = [])
    {

        //user should be a class of its own 

        (new Request())->only(['email','password', 'sometinger']);

        if (empty($args)) {
            $query =  "SELECT * FROM USERS where email = :email AND  password = :password";

            
        }
    }
    public static function logout() {}
    public static function verify($username, $password) {}
    public static function check($username, $password) {}
}
