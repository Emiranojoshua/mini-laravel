<?php

namespace Core\App;

use Core\Connection\Connection;
use Core\Container\Container;
use Core\Container\Provider;
use Core\Exception\Foundation\BaseException;
use Core\Models\User;
use Core\Request\Request;
use Core\Response;
use Core\Route;
use Core\Routing\Router;
use Core\Services\DDOS;
use HTTP\Controllers\WelcomeController;

class App extends DDOS
{

    private static $instance = null;

    private function __construct()
    {

        session_start();
    }


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

            $container = Container::boot();

            // register all services
            new Provider($container);

            // load routes AFTER provider
            require BASE_PATH . '/../routes/web.php';
            // dd(Route::getRoutes());



            // dd("routing");

            Route::route();


        } catch (BaseException $e) {
            // dd($e);
            // dd($e->);
            $errorCode = $e->getErrorCode()  ?: Response::INTERNAL_SERVER_ERROR->getvalue();
            $errorMessage = $e->getErrorMessage() ?: "An error occured/internal server error";
            $errorName = $e->getErrorName() ?: "Internal Server Error";
            $error = $e->getError();

            // $errorFile = $th->getTrace()[0]['file'];
            // $errorline = $th->getTrace()[0]['line'];
            // if (strpos($errorFile, 'functions.php')) {
            //     $errorFile = $th->getTrace()[1]['file'];
            //     $errorline = $th->getTrace()[1]['line'];
            // }
            //return http status code
            // http_response_code($errorCode);
            // dd($error);
            //render error page
            return renderError(
                params: [
                    'errorCode' => $errorCode,
                    'errorMessage' => $errorMessage,
                    'errorFile' => 1111111111111,
                    'errorLine' => 2222222222222,
                    'errorName' => $errorName,
                    'requestData' => Request::getRequest(),
                ],
                response_code: $error,
            );
            //add exception info to text document
        }
    }

    public function __destruct()
    {
        // var_dump($_SESSION);
        echo "deconstructor called from app";
        dc($_SESSION);
        session_unflash();
        // dc($_SESSION);

        // Session::destroy();
    }
}
