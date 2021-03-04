<?php

namespace Tests\Fixtures\Entities;

use Helldar\Support\Facades\Helpers\Instance;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as MainResponse;

final class Response
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

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\JsonResponse|\Illuminate\Testing\TestResponse||null
     */
    public function instance()
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
