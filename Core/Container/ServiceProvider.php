<?php 

namespace Core\Container;

abstract class ServiceProvider
{
    public static $instance;

    protected ContainerHandler $container;

    final public function __construct(ContainerHandler $container)
    {

        $this->container = $container;
        $this->register();
    }

    abstract protected function register();

    public function resolve($abstract)
    {
        return $this->container->resolve($abstract);
    }

    public function call(object|string $objectOrClass, string $method, array $provided = []){
        return $this->container->call($objectOrClass, $method, $provided);
    }
}