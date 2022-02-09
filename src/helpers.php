<?php

/*
 * This file is part of the "dragon-code/api-response" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/api-response
 */

use DragonCode\ApiResponse\Services\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Return a new response from the application.
 *
 * @param mixed|null $data any value to be returned
 * @param int|null $status_code Will be detected automatically (200 or 400). If specified, this value will take precedence.
 * @param array $with any additional value added to the response
 * @param array $headers additional headers passed with the response
 *
 * @return Symfony\Component\HttpFoundation\JsonResponse
 */
function api_response(
    $data = null,
    ?int $status_code = null,
    array $with = [],
    array $headers = []
): JsonResponse {
    return Response::make()
        ->statusCode($status_code)
        ->headers($headers)
        ->data($data)
        ->with($with)
        ->response();
}
