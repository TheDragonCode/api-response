<?php

/**
 * Api Response helper.
 *
 * @param mixed $content
 * @param int   $http_code
 *
 * @return mixed
 */
function api_response($content = null, $http_code = 200)
{
    return \Helldar\ApiResponse\ApiResponseFacade::response($content, $http_code);
}
