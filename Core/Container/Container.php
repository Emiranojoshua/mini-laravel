<?php

namespace Core\Container;

class Container
{
    private static ?ContainerHandler $instance = null;

    final private function __construct() {}

    public static function boot(): ContainerHandler
    {
        if (!self::$instance) {
            self::$instance = new ContainerHandler;

            new Provider(self::$instance);
        }
        return self::$instance;
    }

    public static function resolve(string $class)
    {
        return self::$instance->resolve($class);
    }

    public static function call(object|string $objectOrClass, string $method, array $provided = []){
        return self::$instance->call($objectOrClass, $method, $provided);
    }

    public static function resolveMethodDependencies(object|string $objectOrClass, string $method): array
    {
        return self::$instance->resolveMethodDependencies($objectOrClass, $method);
    }
}
