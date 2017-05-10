<?php

/**
 * Api Response helper.
 *
 * @param int  $code
 * @param null $content
 * @param int  $http_code
 *
 * @return mixed
 */
function api_response($code = 0, $content = null, $http_code = 200)
{
    return \Helldar\ApiResponse\ApiResponseFacade::response($code, $content, $http_code);
}
