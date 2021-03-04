<?php

namespace Tests\Laravel\Parsers\Exception;

use Illuminate\Testing\TestResponse;
use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

final class WithNoDataHideTest extends TestCase
{
    use Requests;

    protected $wrap = false;

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
        $this->assertSame('ok', $this->requestFoo()->getJson());
    }

    public function testStructureErrors()
    {
        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']],
            $this->requestBar()->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => 'FooHttpException', 'data' => 'Foo Http']],
            $this->requestBaz()->getJson()
        );
    }

    public function testStatusCode()
    {
        $this->assertSame(200, $this->requestFoo()->getStatusCode());
        $this->assertSame(500, $this->requestBar()->getStatusCode());
        $this->assertSame(403, $this->requestBaz()->getStatusCode());
    }
}
