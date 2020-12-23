<?php

namespace Tests\Unit\Parsers\Laravel\Resources;

use Tests\TestCase;

final class DoesntWrapTest extends TestCase
{
    protected $wrap = false;

    public function testAsSuccess()
    {
        $response = $this->response($this->laravelSuccessResource());

        $this->assertEquals(json_encode(['foo' => 'Foo', 'bar' => 'Bar']), $this->response()->getContent());

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testAsCreated()
    {
        $response = $this->response($this->laravelCreatedResource());

        $this->assertEquals(json_encode(['foo' => 'Foo', 'bar' => 'Bar']), $this->response()->getContent());

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testAsError()
    {
        $response = $this->response($this->laravelCreatedResource(), 401);

        $this->assertEquals(
            json_encode(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo', 'bar' => 'Bar']]]),
            $this->response()->getContent()
        );

        $this->assertSame(401, $response->getStatusCode());
    }
}
