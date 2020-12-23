<?php

namespace Tests\Fixtures\Entities;

use Symfony\Component\HttpFoundation\JsonResponse;

final class Response
{
    /** @var \Symfony\Component\HttpFoundation\JsonResponse */
    protected $response;

    public function __construct($data = null, int $status_code = null, array $with = [], array $headers = [], bool $wrap = true)
    {
        $this->response = api_response($data, $status_code, $with, $headers, $wrap);
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
}
