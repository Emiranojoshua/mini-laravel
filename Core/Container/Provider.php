<?php 

namespace Core\Container;

use Core\App\App;
use Core\Connection\Connection;

class Provider extends ServiceProvider
{
    //service container code here
    protected function register(){
        //register services here
        $this->container->bind(Connection::class, Connection::class);
        $this->container->singleton(App::class, fn() => "testing singleton");
    }
}