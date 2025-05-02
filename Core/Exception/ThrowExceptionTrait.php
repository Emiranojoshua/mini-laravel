<?php

namespace Core\Exception;

use Core\Response;
use Exception;

trait ThrowExceptionTrait
{
    private static  string $errorName;
    private static  Response $errorCode;
    private static  string $errorMessage;
    public static function ThrowException(Response $error, string $errorMessage)
    {


        $instance = new static;

        $instance::$errorCode = $error;
        $instance::$errorName = $error->name;  
        $instance::$errorMessage = $errorMessage;

        return $instance;
    }

    public static function getErrorCode()
    {
        return static::$errorCode;
    }
    public static function getErrorName()
    {
        return static::$errorName;
    }
    public static function getErrorMessage()
    {
        return static::$errorMessage;
    }

    // public function getLine(): int{
    //     return 333;
    // }
}



// abstract class ThrowExceptionTrait extends Exception
// {
//     public function ThrowException() {
//         // dd($this);
//         return $this;
//     }
// }
