<?php

namespace Helldar\ApiResponse\Support;

use ReflectionClass;

final class Is
{
    public static function object($class): bool
    {
        return is_object($class);
    }

    public static function string($class): bool
    {
        return is_string($class);
    }

    /**
     * @param $class
     *
     * @throws \ReflectionException
     * @return bool
     */
    public static function contract($class): bool
    {
        if (! ($class instanceof ReflectionClass)) {
            $class = new ReflectionClass($class);
        }

        return $class->isInterface();
    }
}
