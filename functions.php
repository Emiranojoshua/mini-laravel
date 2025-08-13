<?php

use Config\Config;
use Core\Exception\RouterException\NotFoundException;
use Core\Request\Request as RequestRequest;
use Core\Response;

use Core\Session\Session;
use HTTP\RedirectResponse;

function dd(mixed  $value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function pp(array | string | int | null $value)
{
    if (is_array($value)) {
        foreach ($value as $print_value) {
            echo '<prev>';
            echo ("{$print_value}" . '</br>');
            echo '</prev>';
        }
        return;
    }
    echo '<prev>';
    echo ("{$value}" . '</br>');
    echo '</prev>';
}

function dc(mixed $value): void
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
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

// must the response code be defined in the response file or can just be retured as int 
//it all comes down to design 
//two options to go with 
//create new git branch to make response_code both int and response
//option two is include the response as response
//option three is to make it buth resonse and int 

function view(string $path, array $params = [], Response $response_code = Response::OK)
{
    (count($params) <= 0) || extract($params);


    $viewFile = BASE_PATH . "/../views/" . strtolower($path) . '.view.php';
    // dd($viewFile);

    file_exists($viewFile) ||  throw NotFoundException::ThrowException(
        "The requested file <b>$path</> does not exist",
        Response::NOT_FOUND,
    );

    // ob_start();
    // http_response_code($response->value);
    status_code($response_code);
    require $viewFile;
    return;
}

function renderError(array $params, Response $response_code = Response::NOT_FOUND)
{
    // dd($params);
    return view('errors/error', $params, $response_code);
}

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


function errors($key,  bool $handle = false)
{

    // $eror = errors('email');
    //         foreach ($email as $value) {
    //             # code...
    //             echo $value;
    //         }
    // return [
    //     "email not registered",
    //     "something went wrong",
    //     "3 reading wrong",
    // ];
    $error =  getSession($key, true);

    if ($handle || is_string($error)) {
        return $error;
    }

    foreach ($error as $value) {
        echo $value . "..  ";
    }    // return getSession($key) ?? '';
}

function old($key, $default = '')
{
    return getSession('_old')[$key] ?? $default;
}

function getSession($key, $all = false)
{
    return Session::get($key, $all);
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

function env(string $key): string
{

    return Config::database()['database']['mysql'][$key] ?? throw NotFoundException::throwException(
        "Config key:$key not found",
        Response::NOT_FOUND
    );
}

function status_code(Response $response_code)
{
    http_response_code($response_code->getValue());
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
