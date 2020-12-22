<?php

use Helldar\ApiResponse\Services\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param  mixed|null  $data
 * @param  int  $status_code
 * @param  array  $with
 * @param  array  $headers
 * @param  bool  $use_data
 * @param  string|null  $exception
 *
 * @throws \ReflectionException
 *
 * @return Symfony\Component\HttpFoundation\JsonResponse
 */
function api_response(
    $data = null,
    int $status_code = 200,
    array $with = [],
    array $headers = [],
    bool $use_data = true,
    string $exception = null
): JsonResponse {
    return Response::init()
        ->exception($exception)
        ->data($data, $status_code, $use_data)
        ->with($with)
        ->headers($headers)
        ->response();
}
