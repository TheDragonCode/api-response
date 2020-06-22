<?php

namespace Helldar\ApiResponse\Support;

use Exception as BaseException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response as LaravelResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

final class Exception
{
    /**
     * @param  object|string  $value
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public static function isError($value = null): bool
    {
        return Instance::of($value, [BaseException::class, Throwable::class]);
    }

    public static function isErrorCode(int $code = 0): bool
    {
        return $code >= 400;
    }

    /**
     * @param  \Exception|\Throwable  $value
     * @param  int  $status_code
     *
     * @throws \ReflectionException
     *
     * @return int
     */
    public static function getCode($value, int $status_code = 400): int
    {
        if (self::isErrorCode($status_code)) {
            return $status_code;
        }

        if ($value instanceof ValidationException) {
            return self::correctStatusCode(
                $value->status ?? Instance::call($value, 'getCode') ?: 0
            );
        }

        return self::correctStatusCode(
            Instance::callsWhenNotEmpty($value, ['getStatusCode', 'getCode']) ?: 0
        );
    }

    public static function getType(Throwable $class, string $exception = null): string
    {
        return $exception ?: Instance::classname($class);
    }

    public static function getData($exception)
    {
        if (Instance::of($exception, [SymfonyResponse::class, LaravelResponse::class])) {
            return Instance::callsWhenNotEmpty($exception, ['getOriginalContent', 'getContent', 'getMessage']);
        }

        if (Instance::of($exception, [Responsable::class, HttpResponseException::class])) {
            return $exception->getResponse();
        }

        if (Instance::of($exception, ValidationException::class)) {
            return $exception->errors();
        }

        return $exception->getMessage();
    }

    protected static function correctStatusCode(int $code): int
    {
        return self::isErrorCode($code) ? $code : 400;
    }
}
