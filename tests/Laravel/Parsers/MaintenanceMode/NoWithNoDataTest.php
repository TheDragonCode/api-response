<?php

namespace Tests\Laravel\Parsers\MaintenanceMode;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

class NoWithNoDataTest extends TestCase
{
    use Requests;

    protected $wrap = false;

    protected $allow_with = false;

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
            ['error' => ['type' => $this->getMaintenanceType(), 'data' => 'Whoops! Something went wrong.']],
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
