<?php

namespace Tests\Laravel\Parsers\Exception;

use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Testing\TestResponse;
use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class WithDataNoHideTest extends TestCase
{
    use Requests;

    protected $hide = false;

    public function testInstance()
    {
        $this->assertTrue($this->requestFoo()->instance() instanceof TestResponse);
        $this->assertTrue($this->requestBar()->instance() instanceof TestResponse);
        $this->assertTrue($this->requestBaz()->instance() instanceof TestResponse);
    }

    public function testType()
    {
        $this->assertJson($this->requestFoo()->getRaw());
        $this->assertJson($this->requestBar()->getRaw());
        $this->assertJson($this->requestBaz()->getRaw());
    }

    public function testStructureSuccess()
    {
        $this->assertSame(['data' => 'ok', 'foo' => 'Foo'], $this->requestFoo()->getJson());
    }

    public function testStructureErrors()
    {
        /*
         * BAR
         */
        $bar = $this->requestBar()->getJson();

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'Foo Bar']],
            Arr::only($bar, 'error')
        );

        $this->assertArrayHasKey('error', $bar);
        $this->assertArrayHasKey('exception', $bar);
        $this->assertArrayHasKey('file', $bar);
        $this->assertArrayHasKey('line', $bar);
        $this->assertArrayHasKey('trace', $bar);

        /*
         * BAZ
         */
        $baz = $this->requestBaz()->getJson();

        $this->assertSame(
            ['error' => ['type' => 'FooHttpException', 'data' => 'Foo Http']],
            Arr::only($baz, 'error')
        );

        $this->assertArrayHasKey('error', $baz);
        $this->assertArrayHasKey('exception', $baz);
        $this->assertArrayHasKey('file', $baz);
        $this->assertArrayHasKey('line', $baz);
        $this->assertArrayHasKey('trace', $baz);
    }

    public function testStatusCode()
    {
        $this->assertSame(200, $this->requestFoo()->getStatusCode());
        $this->assertSame(500, $this->requestBar()->getStatusCode());
        $this->assertSame(403, $this->requestBaz()->getStatusCode());
    }
}
