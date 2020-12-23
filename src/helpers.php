<?php

use Helldar\ApiResponse\Services\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param  mixed|null  $data
 * @param  int|null  $status_code  Will be detected automatically (200 or 400)
 * @param  array  $with
 * @param  array  $headers
 * @param  bool  $wrap
 *
 * @return Symfony\Component\HttpFoundation\JsonResponse
 */
function api_response(
    $data = null,
    int $status_code = null,
    array $with = [],
    array $headers = [],
    bool $wrap = true
): JsonResponse {
    return Response::make()
        ->data($data, $status_code)
        ->wrapper($wrap)
        ->with($with)
        ->headers($headers)
        ->response();
}
