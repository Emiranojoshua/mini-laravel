<?php

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
            echo ("<b>{$value}</b>" . '</br>');
            echo '</prev>';
        }
        return;
    }
    echo '<prev>';
    echo ("<b>{$value}</b>" . '</br>');
    echo '</prev>';
}

function base_path(string $path)
{
    return require BASE_PATH . $path;
}

function view(string $path, array $params = [])
{
    (count($params) <= 0) || extract($params);


    $viewFile = BASE_PATH . "/../views/" . $path . '.view.php';

    file_exists($viewFile) ||  throw NotFoundException::ThrowException(
        Response::NOT_FOUND,
        "The requested file <b>$path</> does not exist",
    );

    // ob_start();
    require $viewFile;
    return ;
}

function renderError(array $params)
{

    return view('errors/error', $params);
}
