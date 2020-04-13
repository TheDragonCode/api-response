<?php

namespace Helldar\ApiResponse\Support;

abstract class Container
{
    protected static $containers = [];

    /**
     * @param  object|string  $class
     *
     * @return object|null
     */
    protected static function makeContainer($class)
    {
        $name = static::containerName($class);

        if (! isset(static::$containers[$name])) {
            static::$containers[$name] = Is::object($class) ? $class : new $class;
        }

        return static::$containers[$name];
    }

    /**
     * @param  object|string  $class
     *
     * @return string
     */
    protected static function containerName($class): string
    {
        return Is::object($class) ? get_class($class) : $class;
    }
}
