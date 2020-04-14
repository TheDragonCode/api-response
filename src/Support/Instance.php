<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Arr;
use ReflectionClass;
use Throwable;

final class Instance extends Container
{
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

        $reflection = static::reflection($haystack);

        foreach (Arr::wrap($needles) as $needle) {
            if (! static::isClassExists($needle)) {
                continue;
            }

            if (
                $haystack instanceof $needle ||
                $reflection->isSubclassOf($needle) ||
                (Is::contract($reflection) && $reflection->implementsInterface($needle))
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string|Throwable  $class
     *
     * @return string
     */
    public static function basename($class): string
    {
        $class = static::classname($class);

        return basename(str_replace('\\', '/', $class));
    }

    public static function classname($class): string
    {
        return static::isObject($class) ? get_class($class) : $class;
    }

    /**
     * @param  Throwable  $object
     * @param  string  $method
     *
     * @return mixed
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
     * @param  string[]  $methods
     *
     * @return mixed
     */
    public static function callsWhenNotEmpty(Throwable $object, $methods)
    {
        foreach (Arr::wrap($methods) as $method) {
            if ($value = static::call($object, $method)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  object|string  $value
     *
     * @return bool
     */
    protected static function isExistsObject($value): bool
    {
        return static::isObject($value) ?: static::isClassExists($value);
    }

    /**
     * @param  mixed  $class
     *
     * @return bool
     */
    protected static function isClassExists($class = null): bool
    {
        return Is::string($class) && class_exists($class);
    }

    /**
     * @param  mixed  $value
     *
     * @return bool
     */
    protected static function isObject($value): bool
    {
        return Is::object($value);
    }

    /**
     * @param  object  $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    protected static function reflection($class): ReflectionClass
    {
        return new ReflectionClass($class);
    }
}
