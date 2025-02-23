<?php

namespace Core\Exception;

use Core\Response;

trait ThrowExceptionTrait
{
    private static  string $errorName;
    private static  int $errorCode;
    private static  string $errorMessage;
    public static function ThrowException(Response $error, string $errorMessage)
    {
        $instance = new static;

        $instance::$errorCode = $error->value;
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
}
