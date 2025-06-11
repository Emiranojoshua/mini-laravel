<?php

namespace Core\App;

use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Core\Route;
use Exception;

class App
{

    private static $instance = null;

    private function __construct()
    {
        $notfound = new NotFoundException();
        dd($notfound->getErrorCode());
    }

    // private function __clone(){}



    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function run()
    {
        try {
            Route::route();
        } catch (Exception $th) {
            $errorCode = method_exists($th, 'getErrorCode') ? get_class($th)::getErrorCode()  : Response::INTERNAL_SERVER_ERROR;
            $errorMessage = method_exists($th, 'getErrorMessage') ? get_class($th)::getErrorMessage()  : "An error occured/internal server error";
            $errorFile = $th->getTrace()[0]['file'];
            $errorline = $th->getTrace()[0]['line'];
            if (strpos($errorFile, 'functions.php')) {
                $errorFile = $th->getTrace()[1]['file'];
                $errorline = $th->getTrace()[1]['line'];
            }
            //return http status code
            // http_response_code($errorCode);

            //render error page
            return renderError(
                [
                    'errorCode' => $errorCode->value,
                    'errorMessage' => $errorMessage,
                    'errorFile' => $errorFile,
                    'errorLine' => $errorline,
                ],
                $errorCode,
            );
        }
    }

    public function __destruct()
    {
        // var_dump($_SESSION);
        session_unflash();
    }
}
