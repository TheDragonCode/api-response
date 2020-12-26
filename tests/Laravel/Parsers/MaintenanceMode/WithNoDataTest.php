<?php

namespace Tests\Laravel\Parsers\MaintenanceMode;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class WithNoDataTest extends TestCase
{
    use Requests;

    protected $wrap = false;

    public function testJson()
    {
        $this->makeDownFile();

        $response = $this->requestFoo();

        $this->assertJson($response->getRaw());
    }

    public function testStructureWithCustomMessage()
    {
        $this->makeDownFile('Foo Bar');

        $response = $this->requestFoo();

        $this->assertSame(
            ['error' => ['type' => 'MaintenanceModeException', 'data' => ['retry_after' => 60, 'message' => 'Foo Bar']]],
            $response->getJson()
        );
    }

    public function testStructureWithDefaultMessage()
    {
        $this->makeDownFile();

        $response = $this->requestFoo();

        $this->assertSame(
            ['error' => ['type' => 'MaintenanceModeException', 'data' => ['retry_after' => 60, 'message' => 'Whoops! Something went wrong.']]],
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
