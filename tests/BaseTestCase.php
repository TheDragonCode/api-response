<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Entities\Response;

abstract class BaseTestCase extends TestCase
{
    protected $use_data = true;

    protected function response($data = null, int $status_code = 200, array $with = []): Response
    {
        return new Response($data, $status_code, $with, [], $this->use_data);
    }
}
