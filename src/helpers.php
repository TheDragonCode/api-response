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
 * @param  bool  $wrap_data
 *
 * @return Symfony\Component\HttpFoundation\JsonResponse
 */
function api_response(
    $data = null,
    int $status_code = 200,
    array $with = [],
    array $headers = [],
    bool $wrap_data = true
): JsonResponse {
    return Response::make()
        ->data($data, $status_code, $wrap_data)
        ->with($with)
        ->headers($headers)
        ->response();
}
