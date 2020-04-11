<?php

namespace Helldar\ApiResponse\Support;

use function basename;
use Exception as BaseException;
use function get_class;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\ValidationException;
use function is_object;
use function is_subclass_of;
use function str_replace;
use Throwable;

final class Exception
{
    public static function isError($value = null): bool
    {
        return static::isException($value) || static::isThrowable($value);
    }

    public static function isException($value = null): bool
    {
        return $value instanceof BaseException || is_subclass_of($value, BaseException::class);
    }

    public static function isThrowable($value = null): bool
    {
        return $value instanceof Throwable || is_subclass_of($value, Throwable::class);
    }

    /**
     * @param  \Exception|\Throwable  $value
     * @param  int  $status_code
     *
     * @return int
     */
    public static function getCode($value, int $status_code = 400): int
    {
        $code = $value instanceof ValidationException
            ? ($value->status ?? $value->getCode())
            : ($value->getCode() ?? $status_code);

        return static::correctStatusCode($code, $status_code);
    }

    public static function getType(Throwable $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }

    public static function getData($exception)
    {
        if ($exception instanceof Responsable || $exception instanceof HttpResponseException) {
            return $exception->getResponse();
        }

        if ($exception instanceof ValidationException) {
            return $exception->errors();
        }

        return $exception->getMessage();
    }

    protected static function correctStatusCode(int $code, int $status_code): int
    {
        $code = static::isCorrectedStatusCode($status_code) ? $status_code : $code;

        return static::isCorrectedStatusCode($code) ? $code : 400;
    }

    protected static function isCorrectedStatusCode(int $code): bool
    {
        return $code >= 400;
    }
}
