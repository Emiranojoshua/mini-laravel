<?php

use Core\Exception\ExceptionHandler;
use Core\Exception\Exceptions;
use Core\Exception\RouterException\NotFoundException;
use Core\Response;

function dd(mixed  $value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function pp(array | string | int $value)
{
    if (is_array($value)) {
        foreach ($value as $value) {
            echo '<prev>';
            echo ("{$value}" . '</br>');
            echo '</prev>';
        }
        return;
    }
    echo '<prev>';
    echo ("{$value}" . '</br>');
    echo '</prev>';
}

function logger(mixed $value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function base_path(string $path)
{
    return require BASE_PATH . $path;
}

function view(string $path, array $params = [])
{
    (count($params) <= 0) || extract($params);


    $viewFile = BASE_PATH . "/../views/" . strtolower($path) . '.view.php';
    // dd($viewFile);

    file_exists($viewFile) ||  throw NotFoundException::ThrowException(
        Response::NOT_FOUND,
        "The requested file <b>$path</> does not exist",
    );

    // ob_start();
    require $viewFile;
    return;
}

function renderError(array $params)
{
    return view('errors/error', $params);
}


function Exception(
    Exceptions | array $exception,
    Response $errorCode = Response::DEFAULT,
    string $error = ''
) {
    if (is_array($exception)) {
        [$exception, $errorCode, $errormessage] = $exception;
        return throw $exception::ThrowException($errorCode, $errormessage);
    }

    return throw $exception->value::ThrowException($errorCode, $error);
};
