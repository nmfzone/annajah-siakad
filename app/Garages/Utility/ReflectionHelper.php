<?php

namespace App\Garages\Utility;

use Exception;
use ReflectionClass;

class ReflectionHelper
{
    /**
     * Determine is a class extends the given class.
     *
     * @param  mixed  $class
     * @param  string  $extend
     * @return bool
     *
     * @throws \Exception
     */
    public static function isExtends($class, $extend)
    {
        $getParent = function ($class) {
            return (new ReflectionClass($class))->getParentClass();
        };

        while ($parent = $getParent($class)) {
            $class = $parent->name;

            if ($parent->name === $extend) {
                return true;
            }
        }

        return false;
    }

    /**
     * Dynamically call protected/private in class.
     *
     * @param  mixed  $class
     * @param  string  $method
     * @param  array  $params
     * @param  bool  $isStatic
     * @return mixed
     *
     * @throws \Exception
     */
    public static function callRestrictedMethod(
        &$class,
        string $method,
        array $params = [],
        $isStatic = false
    ) {
        if (is_string($class)) {
            $class = new ReflectionClass($class);
            $reflectionClass = $class;
        } else {
            $reflectionClass = new ReflectionClass($class);
        }

        $classMethod = $reflectionClass->getMethod($method);
        $classMethod->setAccessible(true);

        return $classMethod->invokeArgs($isStatic ? null : $class, $params);
    }

    /**
     * Dynamically get protected/private property in class.
     *
     * @param  mixed  $class
     * @param  string  $property
     * @return mixed
     *
     * @throws \Exception
     */
    public static function getRestrictedProperty($class, string $property)
    {
        if (is_string($class)) {
            $class = new ReflectionClass($class);
            $reflectionClass = $class;
        } else {
            $reflectionClass = new ReflectionClass($class);
        }

        $classProperty = $reflectionClass->getProperty($property);
        $classProperty->setAccessible(true);

        return $classProperty->getValue($class);
    }

    /**
     * Dynamically set value to protected/private property in class.
     *
     * @param  mixed  $class
     * @param  string  $property
     * @param  mixed  $value
     * @return void
     *
     * @throws \Exception
     */
    public static function setRestrictedProperty(&$class, string $property, $value)
    {
        if (! is_object($class)) {
            throw new Exception('Parameter 1 should be an instance of that class.');
        }

        $reflectionClass = new ReflectionClass($class);
        $classProperty = $reflectionClass->getProperty($property);
        $classProperty->setAccessible(true);

        $classProperty->setValue($value);
    }
}
