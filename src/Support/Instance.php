<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Arr;
use Throwable;

class Instance
{
    public static function of($haystack, $needles): bool
    {
        $needles = Arr::wrap($needles);

        foreach ($needles as $needle) {
            if ($haystack instanceof $needle || is_subclass_of($haystack, $needle)) {
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
}
