<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Entities\Response;

abstract class TestCase extends BaseTestCase
{
    protected $use_data = true;

    protected function response($data = null, int $status_code = 200, array $with = []): Response
    {
        return new Response($data, $status_code, $with, [], $this->use_data);
    }
}
