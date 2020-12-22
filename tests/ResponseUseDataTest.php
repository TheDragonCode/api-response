<?php

namespace Tests;

use Exception;
use Tests\Exceptions\BarException;
use Tests\Exceptions\FooException;

class ResponseUseDataTest extends BaseTestCase
{
    public function testEmpty()
    {
        $this->assertJson($this->response(null)->getContent());
        $this->assertJson($this->response(null, 300)->getContent());
        $this->assertJson($this->response(null, 400)->getContent());
        $this->assertJson($this->response(null, 500)->getContent());

        $this->assertJson($this->response('')->getContent());
        $this->assertJson($this->response('', 300)->getContent());
        $this->assertJson($this->response('', 400)->getContent());
        $this->assertJson($this->response('', 500)->getContent());

        $this->assertEquals(json_encode(['data' => null]), $this->response(null)->getContent());
        $this->assertEquals(json_encode(['data' => null]), $this->response(null, 300)->getContent());
        $this->assertEquals(json_encode(['error' => ['type' => Exception::class, 'data' => null]]), $this->response(null, 400)->getContent());
        $this->assertEquals(json_encode(['error' => ['type' => Exception::class, 'data' => null]]), $this->response(null, 500)->getContent());

        $this->assertEquals(json_encode(['data' => null]), $this->response('')->getContent());
        $this->assertEquals(json_encode(['data' => null]), $this->response('', 300)->getContent());
        $this->assertEquals(json_encode(['error' => ['type' => Exception::class, 'data' => null]]), $this->response('', 400)->getContent());
        $this->assertEquals(json_encode(['error' => ['type' => Exception::class, 'data' => null]]), $this->response('', 500)->getContent());
    }

    public function testData()
    {
        $this->assertJson($this->response('ok')->getContent());
        $this->assertJson($this->response('fail', 400)->getContent());

        $this->assertEquals(json_encode(['data' => 'ok']), $this->response('ok')->getContent());
    }

    public function testStructure()
    {
        $this->assertJsonStringEqualsJsonString(json_encode(['data' => 'ok']), $this->response('ok')->getContent());
        $this->assertJsonStringEqualsJsonString(json_encode(['error' => ['type' => Exception::class, 'data' => 'fail']]),
            $this->response('fail', 400)->getContent());

        $this->assertJsonStringNotEqualsJsonString(json_encode(['data' => 'ok']), $this->response('fail', 400)->getContent());
    }

    public function testDataWith()
    {
        $this->assertJson($this->response('ok', 200, ['foo' => 'bar'])->getContent());
        $this->assertJson($this->response('fail', 400, ['foo' => 'bar'])->getContent());

        $this->assertEquals(json_encode(['data' => 'ok', 'foo' => 'bar']), $this->response('ok', 200, ['foo' => 'bar'])->getContent());

        $this->assertEquals(
            json_encode([
                'error' => [
                    'type' => Exception::class,
                    'data' => 'ok',
                ],
                'foo'   => 'bar',
            ]),
            $this->response('ok', 400, ['foo' => 'bar'])->getContent()
        );

        $this->assertEquals(
            json_encode(['data' => [], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 200, ['foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 200, ['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['type' => Exception::class, 'data' => []], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 400, ['foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['type' => Exception::class, 'data' => []], 'data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 400, ['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq'])->getContent()
        );
    }

    public function testNumber()
    {
        $this->assertEquals(json_encode(['data' => 304]), $this->response(304)->getContent());
        $this->assertEquals(json_encode(['error' => ['type' => Exception::class, 'data' => 304]]), $this->response(304, 400)->getContent());
    }

    public function testStatusCode()
    {
        $this->assertEquals(200, $this->response('ok')->getStatusCode());
        $this->assertEquals(301, $this->response('ok', 301)->getStatusCode());
        $this->assertEquals(401, $this->response('ok', 401)->getStatusCode());
        $this->assertEquals(500, $this->response('ok', 500)->getStatusCode());
    }

    public function testKeyCollisionTesting()
    {
        $this->assertEquals(json_encode(['data' => 'example', 'foo' => 'bar']), $this->response(['data' => 'example', 'foo' => 'bar'])->getContent());
        $this->assertEquals(json_encode(['data' => ['example', 'foo' => 'bar']]), $this->response(['data' => ['example', 'foo' => 'bar']])->getContent());

        $this->assertEquals(
            json_encode(['error' => ['type' => Exception::class, 'data' => 'example'], 'foo' => 'bar']),
            $this->response(['data' => 'example', 'foo' => 'bar'], 400)->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['type' => Exception::class, 'data' => ['foo' => 'bar', 'baz' => 'baq']]]),
            $this->response(['data' => ['foo' => 'bar', 'baz' => 'baq']], 400)->getContent()
        );
    }

    public function testWithExceptionHandler()
    {
        $e = new FooException('Foo');
        $r = $this->response($e);

        $this->assertEquals(
            json_encode(['error' => ['type' => 'FooException', 'data' => 'Foo']]),
            $r->getContent()
        );

        $this->assertSame(405, $r->getStatusCode());
    }

    public function testExceptionHandlerWithAdditionalData()
    {
        $e = new FooException('Foo');
        $r = $this->response($e, 200, ['foo' => 'Bar']);

        $this->assertEquals(
            json_encode(['error' => ['type' => 'FooException', 'data' => 'Foo'], 'foo' => 'Bar']),
            $r->getContent()
        );

        $this->assertSame(405, $r->getStatusCode());
    }

    public function testExceptionHandlerWithReplaceStatusCode()
    {
        $e = new FooException('Foo');
        $r = $this->response($e, 408);

        $this->assertEquals(
            json_encode(['error' => ['type' => 'FooException', 'data' => 'Foo']]),
            $r->getContent()
        );

        $this->assertSame(408, $r->getStatusCode());
    }

    public function testExceptionHandlerWithDefaultStatusCode()
    {
        $e = new BarException('Bar');
        $r = $this->response($e);

        $this->assertEquals(
            json_encode(['error' => ['type' => 'BarException', 'data' => 'Bar']]),
            $r->getContent()
        );

        $this->assertSame(400, $r->getStatusCode());
    }

    public function testExceptionHandlerWithStatusCode()
    {
        $e = new BarException('Bar');
        $r = $this->response($e, 406);

        $this->assertEquals(
            json_encode(['error' => ['type' => 'BarException', 'data' => 'Bar']]),
            $r->getContent()
        );

        $this->assertSame(406, $r->getStatusCode());
    }
}
