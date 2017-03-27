<?php

/**
 * Api Response helper.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @since  2017-02-20
 * @since  2017-03-27 Replaced callable method.
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
