<?php

namespace Core\Session;


class Session
{


    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;

        // $_SESSION['auth'] = [
        //     'user' => [
        //         'email' => 'emiranojoshua@gmail.com',
        //         'password' => 'password',
        //     ],

        // ];
    }

    public static function session_old(array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key == "password") {
                break;
            }
            true ? "" : "";
            $_SESSION['_old'][$key] = $value;
        }
        return;
    }

    public static function flash(array $data): void
    {
        foreach ($data as $key => $value) {
            $_SESSION['_flash'][$key] = $value;
        }
        return;
    }
    public static function flashAll(): array
    {
        return $_SESSION['_flash'];
    }

    public static function unflash(): void
    {
        $_SESSION['_flash'] = [];
        $_SESSION['_old'] = [];
        unset($_SESSION['_flash'], $_SESSION['_old']);
        // $_SESSION = [];
        return;
    }

    public static function get($key, bool $all = false): mixed
    {
        if ($all) {
            return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? "";
        }
        //inclusive of array and not just value returned from array
        return $_SESSION['_flash'][$key][0] ?? $_SESSION[$key] ?? "";
    }


    // public static function old($key): mixed
    // {
    //     return $_SESSION['_flash'][$key][0] ?? "";
    // }

    public static function destroy()
    {
        $_SESSION = [];
        session_unset();
        session_destroy();
    }

    public static function startSession(): void
    {
        session_start();
    }
}
