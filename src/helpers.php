<?php

use Helldar\ApiResponse\Services\ResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param null|mixed $data
 * @param int $status_code
 * @param array $headers
 * @param array $with
 *
 * @return JsonResponse
 */
function api_response($data = null, int $status_code = 200, array $headers = [], array $with = [])
{
    return ResponseService::init()
        ->headers($headers)
        ->data($data)
        ->with($with)
        ->status($status_code)
        ->response();
}
