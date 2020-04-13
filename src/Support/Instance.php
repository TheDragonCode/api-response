<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Arr;
use ReflectionClass;
use Throwable;

class Instance
{
    static protected $instances = [];

    /**
     * @param  mixed  $haystack
     * @param  string|array  $needles
     *
     * @throws \ReflectionException
     * @return bool
     */
    public static function of($haystack, $needles): bool
    {
        if (! static::isExistsObject($haystack)) {
            return false;
        }

        $needles = Arr::wrap($needles);

        foreach ($needles as $needle) {
            if (! static::isClassExists($needle)) {
                continue;
            }

            $reflection = static::reflection($haystack);

            if (
                $reflection->isInstance(static::make($needle)) ||
                $reflection->isSubclassOf($needle) ||
                $reflection->implementsInterface($needle)
            ) {
                return true;
            }
        }

        return false;
    }

    public static function basename(Throwable $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }

    public static function call($object, string $method)
    {
        if (method_exists($object, $method)) {
            return call_user_func([$object, $method]);
        }

        return null;
    }

    public static function callsWhenNotEmpty($object, $methods)
    {
        $methods = Arr::wrap($methods);

        foreach ($methods as $method) {
            if ($value = static::call($object, $method)) {
                return $value;
            }
        }

        return null;
    }

    protected static function isExistsObject($value): bool
    {
        return static::isObject($value) ?: static::isClassExists($value);
    }

    protected static function isClassExists($class): bool
    {
        return is_string($class) && class_exists($class);
    }

    protected static function isObject($value): bool
    {
        return is_object($value);
    }

    /**
     * @param  string|object  $class
     *
     * @throws \ReflectionException
     * @return \ReflectionClass
     */
    protected static function reflection($class)
    {
        return new ReflectionClass($class);
    }

    protected static function make($class)
    {
        $is_object = static::isObject($class);

        $name = $is_object ? get_class($class) : $class;

        if (! isset(static::$instances[$name])) {
            static::$instances[$name] = $is_object ? $class : new $class;
        }

        return static::$instances[$name];
    }
}
