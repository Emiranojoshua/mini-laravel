<?php

namespace Core\Container;

use Closure;
use Core\Exception\ContainerException\ClassNotFoundException;
use Core\Exception\ContainerException\InvalidContainerParameterException;
use Core\Exception\ContainerException\ReflectorInstantiableException;
use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Exception;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

class ContainerHandler
{

    protected array $bindings = [];
    protected array $singletons = [];
    protected array $instances = [];

    public function bind(string $abstract, string|Closure|null $concrete = null)
    {
        $this->bindings[$abstract] = $concrete ?? $abstract;
    }

    public function singleton(string $abstract, string|Closure|null $concrete = null)
    {
        $this->singletons[$abstract] = $concrete ?? $abstract;
    }

    public function resolve($abstract)
    {
        // Check if the instance already exists for singletons
        if (\array_key_exists($abstract, $this->instances)) {
            return $this->instances[$abstract];
        }



        // Determine the concrete implementation
        $concrete = $this->bindings[$abstract] ?? ($this->singletons[$abstract] ?? $abstract);

        $object = $this->build($concrete);

        // IF it is a singleton, store it
        if (\array_key_exists($abstract, $this->singletons)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    private function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete();
        }

        if (!class_exists($concrete)) {
            throw ClassNotFoundException::throwException(
                "$concrete is not a valid class",
                Response::BAD_REQUEST
            );
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw ReflectorInstantiableException::throwException(
                "reflector class $concrete is not isInstantiable",
                Response::BAD_REQUEST
            );
        }

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolve($type->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw ReflectorInstantiableException::throwException(
                    "Cannot resolve the dependency {$parameter->getName()}",
                    Response::BAD_REQUEST
                );
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }

    public function call(object|string $objectOrClass, string $method, array $provided = [])
    {
        $object = is_object($objectOrClass) ? $objectOrClass : $this->resolve($objectOrClass);
        // dd($method);
        // dd(is_object($objectOrClass));

        if (!method_exists($object, $method)) {
            throw ClassNotFoundException::throwException(
                "Method {$method} does not exist on " . get_class($object),
                Response::BAD_REQUEST
            );
        }
        $reflector = new ReflectionMethod($object, method: $method);
        $parameters = $reflector->getParameters();
        $dependencies = [];

        foreach ($parameters as $index => $parameter) {
            $paramName = $parameter->getName();
            $type = $parameter->getType();

            if (\array_key_exists($paramName, $provided)) {
                dd($paramName);
                $dependencies[] = $provided[$paramName];
                continue;
            }
            if (\array_key_exists($index, $provided)) {
                $dependencies[] = $provided[$index];
                continue;
            }

            // 2) Nullable class
            if ($type && !$type->isBuiltin() && $type->allowsNull()) {
                $dependencies[] = null;
                continue;
            }

            // 3) Class dependency
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolve($type->getName());
                continue;
            }

            // 4) Default value
            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            throw InvalidContainerParameterException::throwException(
                "Method {$method} does not exist on " . get_class($object),
                Response::BAD_REQUEST
            );
        }

        return $reflector->invokeArgs($object, $dependencies);
    }
}
