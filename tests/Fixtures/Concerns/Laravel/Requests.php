<?php

namespace Tests\Fixtures\Concerns\Laravel;

use Tests\Fixtures\Entities\Response;

/** @mixin \Tests\Laravel\TestCase */
trait Requests
{
    protected function request(): Response
    {
        return $this->response(
            $this->get('/')
        );
    }
}
