<?php

namespace Core\Container;

use Closure;
use Core\Exception\ContainerException\ClassNotFoundException;
use Core\Exception\ContainerException\ReflectorInstantiableException;
use Core\Exception\RouterException\NotFoundException;
use Core\Response;
use Exception;
use ReflectionClass;

class ContainerHandler
{

    
    // protected array $container = [];

    // public function add($value){
    //     dd($value);
    //     $value =  new $value;
    //     dd($value);
    //     $this->container[] = $value;
    // }

    // //enable singleton call to class
    // private array $resolved = [];

    // public function bind(string $abstract, string $class)
    // {
    //     if (!(array_key_exists($abstract, $this->container))) {
    //         $this->container[$abstract] = $class;
    //     }

    //     return $this;
    // }

    // public function resolve(string $class, array $args = [])
    // {
    //     if (!array_key_exists($class, $this->container)) {
    //         $this->container[$class] = $class;
    //     }

    //     // //checks if singleton is present and return singleton
    //     if (array_key_exists($class, $this->resolved)) {
    //         return $this->resolved[$class];
    //     }

    //     if (!class_exists($class)) {
    //         throw ClassNotFoundException::throwException(
    //             "$class is not a valid class",
    //             Response::BAD_REQUEST
    //         );
    //     }

    //     $reflector  = new ReflectionClass($class);

    //     if (!$reflector->isInstantiable()) {
    //         throw ReflectorInstantiableException::throwException(
    //             "reflector class $class is not isInstantiable",
    //             Response::BAD_REQUEST
    //         );
    //     }

    //     $constructor  = $reflector->getConstructor();

    //     if ($constructor == null) {
    //         return new $class;
    //         // return $reflector->newInstance(...$class);
    //     }

    //     $parameters = $constructor->getParameters();

    //     if (count($parameters) == 0) {
    //         return new $class;

    //         // return $reflector->newInstance($class);
    //         // return new $class;
    //     }

    //     $dependencies = [];

    //     foreach ($parameters as $parameter) {
    //         $type = $parameter->getType();
    //         if ($type && !$type->isBuiltin()) {
    //             $param = $this->resolve($type->getName(), $args);
    //             $dependencies[] = $param;
    //         } elseif ($parameter->isDefaultValueAvailable()) {
    //             $dependencies[] = $parameter->getDefaultValue();
    //         } elseif (array_key_exists($parameter->getName(), $args)) {
    //             $dependencies[] = $args[$parameter->getName()];
    //         } else {
    //             // dd($args);
    //             echo "$parameter is not a valid class";
    //         }
    //     }

    //     $object =  $reflector->newInstanceArgs($dependencies);
    //     $this->resolved[$class] = $object;
    //     return $object;
    // }

    // public function resolveMethod(string $class, string $method)
    // {
    //     $reflector = new ReflectionClass($class);

    //     $method = $reflector->getMethod($method);
    //     $parameters = $method->getParameters();
    //     if ($parameters < 1) {
    //         return [];
    //     }
    //     // dd(value: $parameters);

    //     // pp($parameters);
    //     $dependencies = [];
    //     foreach ($parameters as $parameter) {
    //         $type = $parameter->getType();
    //         if ($type->isBuiltin()) {
    //             if ($parameter->isDefaultValueAvailable()) {
    //                 $dependencies[] = $parameter->getDefaultValue();
    //                 return $dependencies;
    //             } else {
    //                 throw ReflectorInstantiableException::throwException(
    //                     "remove or pass in a default value to the method parameter",
    //                     Response::BAD_REQUEST
    //                 );
    //             }
    //         }
    //         $class = $parameter->getType()->getName();
    //         $param = $this->resolve(class: $class);
    //         $dependencies[] = $param;
    //     }
    //     return $dependencies;
    // }

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
        if (array_key_exists($abstract, $this->instances)) {
            return $this->instances[$abstract];
        }

        // Determine the concrete implementation
        $concrete = $this->bindings[$abstract] ?? ($this->singletons[$abstract] ?? $abstract);

        $object = $this->build($concrete);
        dd($object);
    }

    private function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
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

        if (is_null($constructor)) {
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

}
