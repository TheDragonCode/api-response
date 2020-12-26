<?php

namespace Tests\Laravel\Parsers\MaintenanceMode;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class WithDataTest extends TestCase
{
    use Requests;

    public function testJson()
    {
        $this->makeDownFile();

        $response = $this->requestFoo();

        $this->assertJson($response->getRaw());
    }

    public function testStructure()
    {
        $this->makeDownFile();

        $response = $this->requestFoo();

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Service Unavailable']], $response->getJson());
    }

    public function testStatusCode()
    {
        $this->makeDownFile();

        $response = $this->requestFoo();

        $this->assertSame(503, $response->getStatusCode());
    }
}
