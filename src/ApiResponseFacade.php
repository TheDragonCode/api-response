<?php

namespace Helldar\ApiResponse;

class ApiResponseFacade
{
    /**
     * @param mixed $content
     * @param int   $http_code
     *
     * @return mixed
     */
    public static function response($content = null, $http_code = 200)
    {
        return (new ApiResponse())->get($content, $http_code);
    }
}
