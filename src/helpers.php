<?php
/**
 * @author  Andrey Helldar <helldar@ai-rus.com>
 * @version 2017-02-20
 */

/**
 * Api Response helper.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 * @since  2017-02-20
 *
 * @param int  $code
 * @param null $content
 * @param int  $http_code
 *
 * @return mixed
 */
function api_response($code = 0, $content = null, $http_code = 200)
{
    return \Helldar\ApiResponse\ApiResponse::response($code, $content, $http_code);
}