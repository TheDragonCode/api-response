<?php

use Helldar\ApiResponse\Services\ApiResponseService;

/**
 * Return a new response from the application.
 *
 * @param null|string|int|array|object $content
 * @param int $status_code
 * @param array $headers
 *
 * @return \Symfony\Component\HttpFoundation\JsonResponse
 */
function api_response($content = null, $status_code = 200, $headers = [])
{
    return ApiResponseService::init()
        ->headers($headers)
        ->content($content)
        ->status($status_code)
        ->response();
}
