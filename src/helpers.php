<?php

use Helldar\ApiResponse\Services\ResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param null|string|int|array|object $content
 * @param int $status_code
 * @param array $headers
 * @param array $with
 *
 * @return JsonResponse
 */
function api_response($content = null, $status_code = 200, $headers = [], array $with = [])
{
    return ResponseService::init()
        ->headers($headers)
        ->content($content)
        ->with($with)
        ->status($status_code)
        ->response();
}
