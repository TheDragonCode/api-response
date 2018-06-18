<?php

/**
 * Return a new response from the application.
 *
 * @param null  $content
 * @param int   $status_code
 * @param array $headers
 *
 * @return \Symfony\Component\HttpFoundation\JsonResponse
 */
function api_response($content = null, $status_code = 200, $headers = [])
{
    return \Helldar\ApiResponse\Services\ApiResponseService::init()
        ->headers($headers)
        ->content($content)
        ->status($status_code)
        ->response();
}
