<?php

namespace Tests;

use Helldar\ApiResponse\Services\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseNotUseDataTest extends TestCase
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

        $this->assertEquals('{}', $this->response(null)->getContent());
        $this->assertEquals('{}', $this->response(null, 300)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 400, 'data' => null]]), $this->response(null, 400)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 500, 'data' => null]]), $this->response(null, 500)->getContent());

        $this->assertEquals('{}', $this->response('')->getContent());
        $this->assertEquals('{}', $this->response('', 300)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 400, 'data' => null]]), $this->response('', 400)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 500, 'data' => null]]), $this->response('', 500)->getContent());
    }

    public function testData()
    {
        $this->assertJson($this->response('ok')->getContent());
        $this->assertJson($this->response('fail', 400)->getContent());

        $this->assertEquals(json_encode('ok'), $this->response('ok')->getContent());
    }

    public function testStructure()
    {
        $this->assertJsonStringEqualsJsonString(json_encode('ok'), $this->response('ok')->getContent());
        $this->assertJsonStringEqualsJsonString(json_encode(['error' => ['code' => 400, 'data' => 'fail']]), $this->response('fail', 400)->getContent());

        $this->assertJsonStringNotEqualsJsonString(json_encode('ok'), $this->response('fail', 400)->getContent());
    }

    public function testDataWith()
    {
        $this->assertJson($this->response('ok', 200, [], ['foo' => 'bar'])->getContent());
        $this->assertJson($this->response('fail', 400, [], ['foo' => 'bar'])->getContent());

        $this->assertEquals(json_encode(['data' => 'ok', 'foo' => 'bar']), $this->response('ok', 200, [], ['foo' => 'bar'])->getContent());

        $this->assertEquals(
            json_encode([
                'error' => [
                    'code' => 400,
                    'data' => 'ok',
                ],
                'foo'   => 'bar',
            ]),
            $this->response('ok', 400, [], ['foo' => 'bar'])->getContent()
        );

        $this->assertEquals(
            json_encode(['data' => [], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 200, [], ['foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => []], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 400, [], ['foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => []], 'data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq']),
            $this->response([], 400, [], ['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq'])->getContent()
        );
    }

    public function testNumber()
    {
        $this->assertEquals(json_encode(304), $this->response(304)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 400, 'data' => 304]]), $this->response(304, 400)->getContent());
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
            json_encode(['error' => ['code' => 400, 'data' => 'example'], 'foo' => 'bar']),
            $this->response(['data' => 'example', 'foo' => 'bar'], 400)->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => ['foo' => 'bar', 'baz' => 'baq']]]),
            $this->response(['data' => ['foo' => 'bar', 'baz' => 'baq']], 400)->getContent()
        );
    }

    protected function response($data = null, int $status_code = 200, array $headers = [], array $with = []): JsonResponse
    {
        return Response::init()
            ->headers($headers)
            ->data($data, false)
            ->with($with)
            ->status($status_code)
            ->response();
    }
}
