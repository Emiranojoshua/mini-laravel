<?php 

namespace Core\Container;

abstract class ServiceProvider
{
    public static $instance;

    protected ContainerHandler $container;

    final public function __construct()
    {
        $this->container = Container::load();
        $this->register();
    }

    abstract protected function register();

    public function resolve($abstract)
    {
        return $this->container->resolve($abstract);
    }

    public static function boot(){
        if(static::$instance === null) {
            static::$instance = new static();
         }
        
        return static::$instance;
    }
    
    public function call(object|string $objectOrClass, string $method, array $provided = []){
        return $this->container->call($objectOrClass, $method, $provided);
    }
}