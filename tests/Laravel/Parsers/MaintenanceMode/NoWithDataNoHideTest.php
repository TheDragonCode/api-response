<?php

namespace Tests\Laravel\Parsers\MaintenanceMode;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class NoWithDataNoHideTest extends TestCase
{
    use Requests;

    protected $hide = false;

    protected $with = false;

    public function testType()
    {
        $this->makeDownFile();

        $this->assertJson($this->requestFoo()->getRaw());
        $this->assertJson($this->requestBar()->getRaw());
        $this->assertJson($this->requestBaz()->getRaw());
    }

    public function testStructureSuccess()
    {
        $this->makeDownFile();

        $this->assertSame(
            ['error' => ['type' => $this->getMaintenanceType(), 'data' => 'Service Unavailable']],
            $this->requestFoo()->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => $this->getMaintenanceType(), 'data' => 'Service Unavailable']],
            $this->requestBar()->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => $this->getMaintenanceType(), 'data' => 'Service Unavailable']],
            $this->requestBaz()->getJson()
        );
    }

    public function testStatusCode()
    {
        $this->makeDownFile();

        $this->assertSame(503, $this->requestFoo()->getStatusCode());
        $this->assertSame(503, $this->requestBar()->getStatusCode());
        $this->assertSame(503, $this->requestBaz()->getStatusCode());
    }
}
