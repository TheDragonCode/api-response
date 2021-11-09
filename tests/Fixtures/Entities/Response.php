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

namespace Tests\Fixtures\Entities;

use DragonCode\Support\Facades\Helpers\Instance;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as MainResponse;

class Response
{
    /** @var \Symfony\Component\HttpFoundation\JsonResponse */
    protected $response;

    public function __construct($data = null, int $status_code = null, array $with = [], array $headers = [])
    {
        $this->response = $this->parseResponse($data, $status_code, $with, $headers);
    }

    public function getRaw()
    {
        return $this->response->getContent();
    }

    public function getJson()
    {
        return json_decode($this->getRaw(), true);
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function instance(): JsonResponse
    {
        return $this->response;
    }

    protected function parseResponse($data = null, int $status_code = null, array $with = [], array $headers = [])
    {
        if (Instance::of($data, [JsonResponse::class, MainResponse::class, TestResponse::class])) {
            return $data;
        }

        return api_response($data, $status_code, $with, $headers);
    }
}
