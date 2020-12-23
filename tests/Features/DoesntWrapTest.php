<?php

namespace Tests\Features;

use Tests\Fixtures\Exceptions\BarException;
use Tests\Fixtures\Exceptions\FooException;
use Tests\TestCase;

class DoesntWrapTest extends TestCase
{
    protected $wrap = false;

    public function testEmptyContent()
    {
        $this->assertJson($this->response()->getContent());
        $this->assertJson($this->response(null, 200)->getContent());
        $this->assertJson($this->response(null, 300)->getContent());
        $this->assertJson($this->response(null, 400)->getContent());
        $this->assertJson($this->response(null, 500)->getContent());

        $this->assertJson($this->response('')->getContent());
        $this->assertJson($this->response('', 200)->getContent());
        $this->assertJson($this->response('', 300)->getContent());
        $this->assertJson($this->response('', 400)->getContent());
        $this->assertJson($this->response('', 500)->getContent());

        $this->assertJson($this->response([])->getContent());
        $this->assertJson($this->response([], 200)->getContent());
        $this->assertJson($this->response([], 300)->getContent());
        $this->assertJson($this->response([], 400)->getContent());
        $this->assertJson($this->response([], 500)->getContent());
    }

    public function testEmptyDecoded()
    {
        $this->assertSame([], $this->response()->getDecoded());
        $this->assertSame([], $this->response(null, 200)->getDecoded());
        $this->assertSame([], $this->response(null, 300)->getDecoded());

        $this->assertSame([], $this->response('')->getDecoded());
        $this->assertSame([], $this->response('', 200)->getDecoded());
        $this->assertSame([], $this->response('', 300)->getDecoded());

        $this->assertSame([], $this->response([])->getDecoded());
        $this->assertSame([], $this->response([], 200)->getDecoded());
        $this->assertSame([], $this->response([], 300)->getDecoded());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(null, 400)->getDecoded());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(null, 500)->getDecoded());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response('', 400)->getDecoded());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response('', 500)->getDecoded());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response([], 400)->getDecoded());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response([], 500)->getDecoded());
    }

    public function testData()
    {
        $this->assertJson($this->response('ok')->getContent());
        $this->assertJson($this->response('fail', 400)->getContent());

        $this->assertSame('ok', $this->response('ok')->getDecoded());
    }

    public function testStructure()
    {
        $this->assertSame('ok', $this->response('ok')->getDecoded());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'fail']], $this->response('fail', 400)->getDecoded());

        $this->assertNotSame('ok', $this->response('fail', 400)->getDecoded());
    }

    public function testDataWith()
    {
        $this->assertJson($this->response('ok', 200, ['foo' => 'bar'])->getContent());
        $this->assertJson($this->response('fail', 400, ['foo' => 'bar'])->getContent());

        $this->assertSame(['data' => 'ok', 'foo' => 'bar'], $this->response('ok', 200, ['foo' => 'bar'])->getDecoded());

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'ok'], 'foo' => 'bar'],
            $this->response('ok', 400, ['foo' => 'bar'])->getDecoded()
        );

        $this->assertSame(
            ['data' => null, 'foo' => 'bar', 'baz' => 'baq'],
            $this->response([], 200, ['foo' => 'bar', 'baz' => 'baq'])->getDecoded()
        );

        $this->assertSame(
            [
                'error' => [
                    'type' => 'Exception',
                    'data' => 'Whoops! Something went wrong.',
                ],
                'foo'   => 'bar',
                'baz'   => 'baq',
            ],
            $this->response([], 400, ['foo' => 'bar', 'baz' => 'baq'])->getDecoded()
        );

        $this->assertSame(
            [
                'error' => ['type' => 'Exception', 'data' => null],
                'data'  => ['foo' => 'foo', 'bar' => 'bar'],
                'foo'   => 'bar',
                'baz'   => 'baq',
            ],
            $this->response([], 400, ['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq'])->getDecoded()
        );
    }

    public function testNumber()
    {
        $this->assertSame(json_encode(304), $this->response(304)->getDecoded());
        $this->assertSame(json_encode(['error' => ['type' => 'Exception', 'data' => 304]]), $this->response(304, 400)->getDecoded());
    }

    public function testStatusCode()
    {
        $this->assertSame(200, $this->response('ok')->getStatusCode());
        $this->assertSame(301, $this->response('ok', 301)->getStatusCode());
        $this->assertSame(401, $this->response('ok', 401)->getStatusCode());
        $this->assertSame(500, $this->response('ok', 500)->getStatusCode());
    }

    public function testKeyCollisionTesting()
    {
        $this->assertSame(json_encode(['data' => 'example', 'foo' => 'bar']), $this->response(['data' => 'example', 'foo' => 'bar'])->getDecoded());
        $this->assertSame(json_encode(['data' => ['example', 'foo' => 'bar']]), $this->response(['data' => ['example', 'foo' => 'bar']])->getDecoded());

        $this->assertSame(
            json_encode(['error' => ['type' => 'Exception', 'data' => 'example'], 'foo' => 'bar']),
            $this->response(['data' => 'example', 'foo' => 'bar'], 400)->getDecoded()
        );

        $this->assertSame(
            json_encode(['error' => ['type' => 'Exception', 'data' => ['foo' => 'bar', 'baz' => 'baq']]]),
            $this->response(['data' => ['foo' => 'bar', 'baz' => 'baq']], 400)->getDecoded()
        );
    }

    public function testExceptionHandlerWithAdditionalData()
    {
        $e = new FooException('Foo');
        $r = $this->response($e, 200, ['foo' => 'Bar']);

        $this->assertSame(
            json_encode(['error' => ['type' => 'FooException', 'data' => 'Foo'], 'foo' => 'Bar']),
            $r->getDecoded()
        );

        $this->assertSame(405, $r->getStatusCode());
    }

    public function testExceptionHandlerWithReplaceStatusCode()
    {
        $e = new FooException('Foo');
        $r = $this->response($e, 408, ['foo' => 'Bar']);

        $this->assertSame(
            json_encode(['error' => ['type' => 'FooException', 'data' => 'Foo'], 'foo' => 'Bar']),
            $r->getDecoded()
        );

        $this->assertSame(408, $r->getStatusCode());
    }

    public function testExceptionHandlerWithDefaultStatusCode()
    {
        $e = new BarException('Bar');
        $r = $this->response($e);

        $this->assertSame(
            json_encode(['error' => ['type' => 'BarException', 'data' => 'Bar']]),
            $r->getDecoded()
        );

        $this->assertSame(400, $r->getStatusCode());
    }

    public function testExceptionHandlerWithStatusCode()
    {
        $e = new BarException('Bar');
        $r = $this->response($e, 406);

        $this->assertSame(
            json_encode(['error' => ['type' => 'BarException', 'data' => 'Bar']]),
            $r->getDecoded()
        );

        $this->assertSame(406, $r->getStatusCode());
    }
}
