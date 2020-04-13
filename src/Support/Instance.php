<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Arr;
use ReflectionClass;
use Throwable;

class Instance
{
    protected static $instances = [];

    /**
     * @param  mixed  $haystack
     * @param  array|string  $needles
     *
     * @throws \ReflectionException
     *
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

    /**
     * @param  Throwable  $object
     * @param  string  $method
     *
     * @return bool
     */
    public static function call(Throwable $object, string $method)
    {
        if (method_exists($object, $method)) {
            return call_user_func([$object, $method]);
        }

        return null;
    }

    /**
     * @param  Throwable  $object
     * @param  string|array  $methods
     *
     * @return mixed|null
     */
    public static function callsWhenNotEmpty(Throwable $object, $methods)
    {
        $methods = Arr::wrap($methods);

        foreach ($methods as $method) {
            if ($value = static::call($object, $method)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  mixed  $value
     *
     * @return bool
     */
    protected static function isExistsObject($value): bool
    {
        return static::isObject($value) ?: static::isClassExists($value);
    }

    /**
     * @param  mixed  $value
     *
     * @return bool
     */
    protected static function isClassExists($class): bool
    {
        return is_string($class) && class_exists($class);
    }

    /**
     * @param  mixed  $value
     *
     * @return bool
     */
    protected static function isObject($value): bool
    {
        return is_object($value);
    }

    /**
     * @param  Throwable  $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    protected static function reflection(Throwable $class): ReflectionClass
    {
        return new ReflectionClass($class);
    }

    /**
     * @param  Throwable|string  $class
     *
     * @return Throwable
     */
    protected static function make($class): Throwable
    {
        $is_object = static::isObject($class);

        $name = $is_object ? get_class($class) : $class;

        if (! isset(static::$instances[$name])) {
            static::$instances[$name] = $is_object ? $class : new $class;
        }

        return static::$instances[$name];
    }
}
