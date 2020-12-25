<?php

namespace Tests\Laravel\Parsers\MaintenanceMode;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class NoWithDataTest extends TestCase
{
    use Requests;

    protected $allow_with = false;

    public function testResponse()
    {
        $this->makeDownFile();

        $response = $this->request();

        $this->assertSame(503, $response->getStatusCode());
        $this->assertSame(['error' => ['type' => 'PreventRequestsDuringMaintenance', 'data' => 'Service Unavailable']], $response->getRaw());
    }
}
