<?php

namespace Tests\Fixtures\Concerns\Laravel;

use Tests\Fixtures\Entities\Response;

/** @mixin \Tests\Laravel\TestCase */
trait Requests
{
    protected function requestFoo(): Response
    {
        return $this->request('/foo');
    }

    protected function requestBar(): Response
    {
        return $this->request('/bar');
    }

    protected function requestBaz(): Response
    {
        return $this->request('/baz');
    }

    protected function request(string $uri): Response
    {
        return $this->response(
            $this->get($uri)
        );
    }
}
