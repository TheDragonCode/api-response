<?php

namespace Tests\Fixtures\Entities;

final class Response
{
    protected $content;

    protected $status_code;

    public function __construct($data = null, int $status_code = 200, array $with = [], array $headers = [], bool $wrap = true)
    {
        $response = api_response($data, $status_code, $with, $headers, $wrap);

        $this->content     = $response->getContent();
        $this->status_code = $response->getStatusCode();
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }
}
