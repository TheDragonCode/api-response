<?php

use Helldar\ApiResponse\Services\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param  mixed|null  $data  Any value to be returned.
 * @param  int|null  $status_code  Will be detected automatically (200 or 400). If specified, this value will take precedence.
 * @param  array  $with  Any additional value added to the response.
 * @param  array  $headers  Additional headers passed with the response.
 * @param  bool  $wrap  Whether to wrap data in the `data` key.
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
        ->statusCode($status_code)
        ->headers($headers)
        ->wrapper($wrap)
        ->data($data)
        ->with($with)
        ->response();
}
