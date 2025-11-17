<?php 

namespace Core\Container;

use Core\App\App;
use Core\Connection\Connection;
use Core\Request\Request;

class Provider extends ServiceProvider
{
    protected function register(){
        //register services here
        $this->container->bind(Connection::class, Connection::class);
        $this->container->singleton("testing", fn() => new Request());
    }
    
}