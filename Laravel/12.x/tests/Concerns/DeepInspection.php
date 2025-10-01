<?php

/**
 * The deep inspection global helpers
 */

declare(strict_types=1);

if (!function_exists('callMethod')) {
    /**
     * Call protected or private method
     *
     * @note if you put a @throws on this, it'll start generating "non caught exceptions" in all of the tests in your IDE
     */
    function callMethod($object, $methodName, array $arguments = [])
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return empty($arguments) ? $method->invoke($object) : $method->invokeArgs($object, $arguments);
    }
}

if (!function_exists('getProperty')) {
    /**
     * Get protected or private property
     *
     * @note if you put a @throws on this, it'll start generating "non caught exceptions" in all of the tests in your IDE
     */
    function getProperty($object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
