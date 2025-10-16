<?php

namespace Core\Session;

use Core\Exception\ArgumentException\InvalidArgumentException;
use Core\Response;

class Session
{
    public static function put(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function session_old(array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key == "password") {
                continue;
            }
            $_SESSION['_old'][$key] = $value;
        }
        return;
    }

    public static function flash(array $data): void
    {
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $_SESSION['_flash'][$key] = [$value];
                continue;
            }
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

    public static function get(string $key, bool $all = false): mixed
    {
        // return "this was returned";
        if ($all) {
            return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? null;
        }
        //inclusive of array and not just value returned from array
        return $_SESSION['_flash'][$key][0] ?? $_SESSION[$key] ?? null;
    }

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
