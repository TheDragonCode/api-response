<?php

namespace Tests\Unit\Parsers\Laravel\Resources;

use Tests\TestCase;

final class WrappedTest extends TestCase
{
    public function testAsSuccess()
    {
        $response = $this->response($this->laravelSuccessResource());

        $this->assertEquals(json_encode(
            [
                'data' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar',
                ],
                'baz'  => 'Baz',
            ]
        ), $response->getContent());

        $this->assertSame(200, $response->getStatusCode());
    }

    public function testAsCreated()
    {
        $response = $this->response($this->laravelCreatedResource());

        $this->assertEquals(json_encode(
            [
                'data' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar',
                ],
                'baz'  => 'Baz',
            ]
        ), $response->getContent());

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testAsHardStatusCode()
    {
        $response = $this->response($this->laravelCreatedResource(), 400);

        $this->assertEquals(json_encode(
            [
                'error' => [
                    'type' => 'Exception',
                    'data' => ['foo' => 'Foo', 'bar' => 'Bar'],
                ],
                'baz'   => 'Baz',
            ]
        ), $response->getContent());

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testAsError()
    {
        $response = $this->response($this->laravelSuccessResource(), 401);

        $this->assertEquals(
            json_encode([
                'error' => [
                    'type' => 'Exception',
                    'data' => [
                        'foo' => 'Foo',
                        'bar' => 'Bar',
                    ],
                ],
                'baz'   => 'Baz',
            ]),
            $response->getContent()
        );

        $this->assertSame(401, $response->getStatusCode());
    }
}
