<?php

use Helldar\ApiResponse\Services\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param mixed|null $data
 * @param int $status_code
 * @param array $headers
 * @param array $with
 * @param bool $use_data
 *
 * @return JsonResponse
 */
function api_response($data = null, int $status_code = 200, array $headers = [], array $with = [], bool $use_data = true)
{
    return Response::init()
        ->headers($headers)
        ->data($data, $use_data)
        ->with($with)
        ->status($status_code)
        ->response();
}
