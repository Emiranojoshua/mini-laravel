<?php

namespace Core\Container;

use Core\Exception\ContainerException\ClassNotFoundException;
use Core\Exception\ContainerException\ReflectorInstantiableException;
use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Exception;
use ReflectionClass;

class ContainerHandler
{
    private array $container = [];

    //enable singleton call to class
    private array $resolved = [];

    public function bind(string $abstract, string $class)
    {
        if (!(array_key_exists($abstract, $this->container))) {
            $this->container[$abstract] = $class;
        }

        return $this;
    }

    public function resolve(string $class, array $args = [])
    {
        if (!array_key_exists($class, $this->container)) {
            $this->container[$class] = $class;
        }

        // //checks if singleton is present and return singleton
        if (array_key_exists($class, $this->resolved)) {
            return $this->resolved[$class];
        }

        if (!class_exists($class)) {
            throw ClassNotFoundException::throwException(
                "$class is not a valid class",
                Response::BAD_REQUEST
            );
        }

        $reflector  = new ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw ReflectorInstantiableException::throwException(
                "reflector class $class is not isInstantiable",
                Response::BAD_REQUEST
            );
        }

        $constructor  = $reflector->getConstructor();

        if ($constructor == null) {
            return new $class;
            // return $reflector->newInstance(...$class);
        }

        $parameters = $constructor->getParameters();

        if (count($parameters) == 0) {
            return new $class;

            // return $reflector->newInstance($class);
            // return new $class;
        }

        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type && !$type->isBuiltin()) {
                $param = $this->resolve($type->getName(), $args);
                $dependencies[] = $param;
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } elseif (array_key_exists($parameter->getName(), $args)) {
                $dependencies[] = $args[$parameter->getName()];
            } else {
                // dd($args);
                echo "$parameter is not a valid class";
            }
        }

        $object =  $reflector->newInstanceArgs($dependencies);
        $this->resolved[$class] = $object;
        return $object;
    }

    public function resolveMethod(string $class, string $method)
    {
        $reflector = new ReflectionClass($class);

        $method = $reflector->getMethod($method);
        $parameters = $method->getParameters();
        if ($parameters < 1) {
            return [];
        }
        // dd(value: $parameters);

        // pp($parameters);
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                    return $dependencies;
                } else {
                    throw ReflectorInstantiableException::throwException(
                        "remove or pass in a default value to the method parameter",
                        Response::BAD_REQUEST
                    );
                }
            }
            $class = $parameter->getType()->getName();
            $param = $this->resolve(class: $class);
            $dependencies[] = $param;
        }
        return $dependencies;
    }
}
