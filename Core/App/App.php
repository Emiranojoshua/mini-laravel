<?php

namespace Core\App;

use Core\Exception\Foundation\BaseException;
use Core\Exception\Foundation\ExceptionDetails;
use Core\Request\Request;
use Core\Route;
use Core\Services\DDOS;

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
            Route::route();
        } catch (BaseException $e) {

            try {
                $details = new ExceptionDetails($e);
                return renderError(
                    params: [
                        'errorCode'    => $details->getErrorCode(),
                        'errorMessage' => $details->getErrorMessage(),
                        'errorName'    => $details->getErrorName(),
                        'errorFile'    => $details->getOriginFile(),
                        'errorLine'    => $details->getOriginLine(),
                        'errorTrace'   => $details->getTrace(),           // array trace
                        'traceString'  => $details->getTraceString(),   // formatted string
                        'requestData'  => Request::getRequest(),
                        'method'      => Request::getRequestMethod(),
                        'uri'      => Request::getRequestUri(),
                        'time' => date('Y-m-d H:i:s'),
                    ],
                );
            } catch (BaseException $e) {
                return renderError(
                    params: [
                        'errorCode'    => $details->getErrorCode(),
                        'errorMessage' => $details->getErrorMessage(),
                        'errorName'    => $details->getErrorName(),
                        'errorFile'    => $details->getOriginFile(),
                        'errorLine'    => $details->getOriginLine(),
                        'errorTrace'   => $details->getTrace(),           // array trace
                        'traceString'  => $details->getTraceString(),   // formatted string
                        'requestData'  => Request::getRequest(),
                        'method'      => Request::getRequestMethod(),
                        'uri'      => Request::getRequestUri(),
                        'time' => date('Y-m-d H:i:s'),
                    ],
                );
            }
        }
    }

    public function __destruct()
    {
        session_unflash();
    }
}
