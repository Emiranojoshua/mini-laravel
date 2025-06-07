<?php

namespace Core\Models\Resource;

use Core\Connection\Connection as Database;
use Core\Container\Container;

trait ModelHandler
{

    public $attributes = [];
    private $database;


    public function __construct()
    {
        // $this->database = Container::resolve(Database::class);
    }

    public function create($attributes)
    {
        
      dd($attributes);

       //insertt into database 'model'

    //    dd($this);
        

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
