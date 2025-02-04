<?php

function dd(mixed $value)
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

function base_path($path)
{
    return require BASE_PATH . $path;
}

function view($path)
{
    return require BASE_PATH . "/../views/" . $path . '.view.php';
}
