<?php

namespace Core\App;

use Core\Connection\Connection;
use Core\Container\Container;
use Core\Container\Provider;
use Core\Exception\Foundation\BaseException;
use Core\Exception\Foundation\ExceptionDetails;
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
            require BASE_PATH . '/../routes/web.php';
            // test();
            Route::route();
        } catch (BaseException $e) {

            $exceptionDetails = Container::resolve(ExceptionDetails::class);    
            dd();


            // dd($e->getTrace());
            // $errorCode = $e->getErrorCode() ?: Response::INTERNAL_SERVER_ERROR->getValue();
            // $errorMessage = $e->getErrorMessage() ?: "An error occurred/internal server error";
            // $errorName = $e->getErrorName() ?: "Internal Server Error";
            // $error = $e->getError();

            // dd([
            //     // 'errorCode'    => $errorCode,
            //     // 'errorMessage' => $errorMessage,
            //     // 'errorName'    => $errorName,
            //     // 'errorFile'    => $e->getFile(),
            //     // 'errorLine'    => $e->getLine(),
            //     'errorTrace'   => $e->getTrace(),           // array trace
            //     // 'traceString'  => $e->getTraceAsString(),   // formatted string
            //     // 'requestData'  => Request::getRequest(),
            //     // 'requestMethod'=> Request::getRequestMethod(),
            // ]);

            // return renderError(
            //     params: [
            //         'errorCode'    => $errorCode,
            //         'errorMessage' => $errorMessage,
            //         'errorName'    => $errorName,
            //         'errorFile'    => $e->getFile(),
            //         'errorLine'    => $e->getLine(),
            //         'errorTrace'   => $e->getTrace(),           // array trace
            //         'traceString'  => $e->getTraceAsString(),   // formatted string
            //         'requestData'  => Request::getRequest(),
            //     ],
            //     response_code: $error,
            // );
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
