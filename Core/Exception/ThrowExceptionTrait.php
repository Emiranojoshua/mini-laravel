<?php

namespace Core\Exception;

trait ThrowExceptionTrait
{
    private static  string $errorMessage;
    private static  int $errorCode;
    public static function ThrowException($errorMessage, $errorCode)
    {
        $instance = new static;

        $instance::$errorCode = $errorCode;
        $instance::$errorMessage = $errorMessage;

        return $instance;
    }

    public static function getErrorCode()
    {
        return static::$errorCode;
    }
    public static function getErrorMessage()
    {
        return static::$errorMessage;
    }
}
