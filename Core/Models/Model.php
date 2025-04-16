<?php

namespace Core\Models;

use Core\Connection\Connection as Database;
use Core\Container\Container;

abstract class Model
{

    public $attributes = [];
    private $database;


    public function __construct()
    {
        $this->database = Container::resolve(Database::class);
    }

    public function create($attributes)
    {
        $this->attributes = $attributes;

        // dd($attributes);

        return $this;
    }
    //read
    //write
    //update
    //delete
    //secondaty ----
    //join

    public function read(array $attributes): mixed
    {
        return 'reding databaste';
    }
    public function update(array $attributes): mixed
    {
        return 'update databaste';
    }
    public function delete(array $attributes): mixed
    {
        return 'delete databaste';
    }
    public function write(array $attributes): mixed
    {
        return 'write databaste';
    }
}
