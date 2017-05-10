<?php

namespace Helldar\ApiResponse;

class ApiResponseFacade
{
    /**
     * @param int  $code
     * @param null $content
     * @param int  $http_code
     *
     * @return mixed
     */
    public static function response($code = 0, $content = null, $http_code = 200)
    {
        return (new ApiResponse())->get($code, $content, $http_code);
    }
}
