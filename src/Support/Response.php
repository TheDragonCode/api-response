<?php

namespace Helldar\ApiResponse\Support;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Responsable;

final class Response
{
    public static function get($data)
    {
        return $data instanceof Responsable
            ? static::toResponse($data)
            : $data;
    }

    private static function toResponse(Responsable $content)
    {
        return $content
            ->toResponse(Container::getInstance()->make('request'))
            ->getData();
    }
}
