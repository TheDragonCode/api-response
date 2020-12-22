<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Instance;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Responsable;

final class Response
{
    public static function get($data)
    {
        return Instance::of($data, Responsable::class) ? self::toResponse($data) : $data;
    }

    protected static function toResponse(Responsable $content)
    {
        return $content->toResponse(self::request())->getData();
    }

    protected static function request()
    {
        return Container::getInstance()->make('request');
    }
}
