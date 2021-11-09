<?php

namespace Tests\Laravel\Parsers\MaintenanceMode;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

class WithNoDataTest extends TestCase
{
    use Requests;

    protected $wrap = false;

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

        $this->assertSame(
            ['error' => ['type' => $this->getMaintenanceType(), 'data' => 'Service Unavailable']],
            $response->getJson()
        );
    }

    public function testStatusCode()
    {
        $this->makeDownFile();

        $response = $this->requestFoo();

        $this->assertSame(503, $response->getStatusCode());
    }
}
