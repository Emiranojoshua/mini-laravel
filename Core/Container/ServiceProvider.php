<?php 

namespace Core\Container;

abstract class ServiceProvider
{
    protected ContainerHandler $container;

    public function __construct(ContainerHandler $container)
    {
        $this->container = $container;
    }

    abstract protected function register();

    public function resolve($abstract)
    {
        return $this->container->resolve($abstract);
    }
}