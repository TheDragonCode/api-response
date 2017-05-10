<?php

namespace Helldar\ApiResponse;

class ApiResponseFacade
{
    /**
     * @param mixed $content
     * @param int   $code
     * @param int   $http_code
     *
     * @return mixed
     */
    public static function response($content = null, $code = 0, $http_code = 200)
    {
        return (new ApiResponse())->get($content, $code, $http_code);
    }
}
