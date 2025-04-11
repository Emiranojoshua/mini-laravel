<?php

namespace Core\App;

use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Core\Route;
use Exception;

class App
{
    public static function run()
    {
        try {
            static::startSession();
            Route::route();
            // throw new Exception('adfadfa`');
        } catch (Exception $th) {
            $errorCode = method_exists($th, 'getErrorCode') ? get_class($th)::getErrorCode()  : 500;
            $errorMessage = method_exists($th, 'getErrorMessage') ? get_class($th)::getErrorMessage()  : "An error occured/internal server error";
            $errorFile = $th->getTrace()[0]['file'];
            $errorline = $th->getTrace()[0]['line'];
            if(strpos($errorFile, 'functions.php')){
                $errorFile = $th->getTrace()[1]['file'];
                $errorline = $th->getTrace()[1]['line'];
            }
            //return http status code
            http_response_code($errorCode);

            //render error page
            return renderError([
                'errorCode' => $errorCode,
                'errorMessage' => $errorMessage,
                'errorFile' => $errorFile,
                'errorLine' => $errorline,
            ]);
        }
    }

    public static function startSession()
    {
        // return throw new Exception('eror caut from start esssion');
        session_start();
    }
}
