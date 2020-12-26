<?php

namespace Tests\Laravel\Parsers\Exception;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class WithDataTest extends TestCase
{
    use Requests;

    public function testJson()
    {
        $response = $this->requestBar();

        $this->assertJson($response->getRaw());
    }

    public function testStructure()
    {
        $response = $this->requestBar();

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'Foo Bar']],
            $response->getJson()
        );
    }

    public function testStatusCode()
    {
        $response = $this->requestBar();

        $this->assertSame(500, $response->getStatusCode());
    }
}
