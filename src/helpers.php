<?php

/**
 * Api Response helper.
 *
 * @param mixed $content
 * @param int   $code
 * @param int   $http_code
 *
 * @return mixed
 */
function api_response($content = null, $code = 0, $http_code = 200)
{
    return \Helldar\ApiResponse\ApiResponseFacade::response($content, $code, $http_code);
}
