<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Instance;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

final class Response
{
    public static function get($data)
    {
        return Instance::of($data, Responsable::class) ?
            self::toResponse($data)->getData()
            : $data;
    }

    protected static function toResponse(Responsable $content): BaseResponse
    {
        return $content->toResponse(self::request());
    }

    protected static function request()
    {
        return Container::getInstance()->make('request');
    }
}
