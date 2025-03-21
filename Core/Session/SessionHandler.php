<?php

namespace Core\Session;

class SessionHandler
{

    public function put($key, $value)
    {
        $_SESSION[$key] = $value;

        $_SESSION['auth'] = [
            'user' => [
                'email' => 'emiranojoshua@gmail.com',
                'password' => 'password',
            ],
            
        ];
    
    }

    public function get()
    {
        return $_SESSION;
    }

    public function unset(){
        $_SESSION = [];
        session_unset();
        session_destroy();
    }
}
