<?php

use Config\Config;
use Core\Exception\ExceptionHandler;
use Core\Exception\Exceptions;
use Core\Exception\RouterException\NotFoundException;
use Core\Request\Request as RequestRequest;
use Core\Response;
use Core\Routing\Request;
use Core\Routing\Router;
use Core\Session\Session;
use HTTP\RedirectResponse;

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

function view(string $path, array $params = [], Response $response_code = Response::OK)
{
    (count($params) <= 0) || extract($params);


    $viewFile = BASE_PATH . "/../views/" . strtolower($path) . '.view.php';
    // dd($viewFile);

    file_exists($viewFile) ||  throw NotFoundException::ThrowException(
        Response::NOT_FOUND,
        "The requested file <b>$path</> does not exist",
    );

    // ob_start();
    // http_response_code($response->value);
    request_status_code($response_code);
    require $viewFile;
    return;
}

function renderError(array $params, Response $response_code = Response::NOT_FOUND)
{
    // dd($params);
    return view('errors/error', $params, $response_code);
}


function exception(
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

function session_flash(array $data)
{
    Session::flash($data);
    //JUST INCASE RETURN CAUSES HARM TO CODEBASE
    // return;
}

function session_old(array $value): void
{
    Session::session_old($value);
}


function errors($key)
{
    return getSession($key) ?? '';
}

function old($key, $default = '')
{
    return getSession('_old')[$key] ?? $default;
}

function getSession($key)
{
    return Session::get($key);
}

function session_unflash()
{
    Session::unflash();
    return;
}

function flashAll()
{
    return Session::flashAll();
}

function env(string $key)
{

    return Config::database()['database']['mysql'][$key] ?? exception(
        Exceptions::NOTFOUNDEXCEPTION->throw(
            "Config key:$key not found"
        )
    );
}

function request_status_code(Response $response_code)
{
    http_response_code($response_code->value);
    return;
}

function redirect(string $url = '/', Response $response_code = Response::REDIRECT): RedirectResponse
{
    return RedirectResponse::make($url, $response_code);
}

function back(): RedirectResponse
{
    $request = RequestRequest::getRequest();
    dd($request);
    $referer = $_SERVER['HTTP_REFERER'] ?? '/';
    return redirect($referer);
}
