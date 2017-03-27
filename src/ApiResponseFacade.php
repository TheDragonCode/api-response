<?php

namespace Helldar\ApiResponse;


class ApiResponseFacade
{
    /**
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-03-27
     *
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