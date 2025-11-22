<?php

use Core\Exception\ContainerException\ClassNotFoundException;
use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Core\Response\RedirectResponse;
use Core\Session\Session;

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


function view(string $path, array $params = [], Response $response_code = Response::OK)
{
    (count($params) <= 0) || extract($params);


    $viewFile = BASE_PATH . "/../views/" . strtolower($path) . '.view.php';
    // dd($viewFile);

    file_exists($viewFile) ||  throw NotFoundException::ThrowException(
        "The requested file <b>$path</> does not exist",
        Response::NOT_FOUND,
    );

    status_code($response_code);
    require $viewFile;
    return;
}

function renderError(array $params)
{
    return view('errors/error', $params);
}

function session_flash(array $data)
{
    Session::flash($data);

}

function session_old(array $value): void
{
    Session::session_old($value);
}

function session_add(string $key, mixed $value){
    Session::put($key, $value);
}

function session_get(string $key, bool $all = false): mixed{
    return Session::get($key, $all);
}


function errors($key,  bool $handle = false)
{
    $error =  getSession($key, true);

    if ($handle || is_string($error)) {
        return $error;
    }
    if($error ==  null){
        return;
    }

    foreach ($error as $value) {
        echo $value . "..  ";
    }    
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

function status_code(Response $response_code)
{
    http_response_code($response_code->getValue());
    return;
}

function redirect(string $url = '/', Response $statusCode = Response::OK)
{
    return RedirectResponse::make($url, $statusCode);
}

function test(){
    ClassNotFoundException::throwException(
        "Test Exception from functions.php",
        Response::BAD_REQUEST
    );
}


function renderStackTrace(array $trace): string
{
    $html = '<div class="stack-trace">';

    foreach ($trace as $frame) {
        $file = $frame['file'] ?? 'unknown file';
        $line = $frame['line'] ?? 0;

        $class = $frame['class'] ?? '';
        $type  = $frame['type'] ?? '';
        $func  = $frame['function'] ?? '';

        $method = $class . $type . $func . '()';

        $html .= "
            <div class=\"stack-item\">
                <div class=\"stack-file\">" . htmlspecialchars(basename($file)) . ":$line</div>
                <div class=\"stack-method\">" . htmlspecialchars($method) . "</div>
            </div>
        ";
    }

    $html .= "</div>";
    return $html;
}


