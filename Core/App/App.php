<?php

namespace Core\App;


use Core\Route;
use Exception;

class App
{


    public static function run() {
        static::startSession();

        try {
            Route::route();
        } catch (Exception $th) {
            $errorCode = method_exists($th, 'getErrorCode') ? get_class($th)::getErrorCode()  : 500;
            $errorMessage = method_exists($th, 'getErrorMessage') ? get_class($th)::getErrorMessage()  : "Internal Server Error";
        
            //return http status code
            http_response_code($errorCode);
        
            // dd([$errorCode, $errorMessage]);
        
            //render error page
            return renderError([
                'errorCode' => $errorCode,
                'errorMessage' => $errorMessage
            ]);
        }
        
    }

    public static function startSession()
    {
        session_start();
    }


}














