<?php

namespace Tests\Fixtures\Concerns;

use Tests\Fixtures\Entities\Response;

/** @mixin \Tests\Laravel\TestCase */
trait Responsable
{
    protected function response($data = null, int $status_code = null, array $with = []): Response
    {
        return new Response($data, $status_code, $with);
    }
}
