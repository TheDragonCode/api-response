<?php

namespace Helldar\ApiResponse\Tests;

use PHPUnit\Framework\TestCase;

class ResponseUseDataTest extends TestCase
{
    public function testEmpty()
    {
        $this->assertJson(api_response(null)->getContent());
        $this->assertJson(api_response(null, 300)->getContent());
        $this->assertJson(api_response(null, 400)->getContent());
        $this->assertJson(api_response(null, 500)->getContent());

        $this->assertJson(api_response('')->getContent());
        $this->assertJson(api_response('', 300)->getContent());
        $this->assertJson(api_response('', 400)->getContent());
        $this->assertJson(api_response('', 500)->getContent());

        $this->assertEquals(json_encode(['data' => null]), api_response(null)->getContent());
        $this->assertEquals(json_encode(['data' => null]), api_response(null, 300)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 400, 'data' => null]]), api_response(null, 400)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 500, 'data' => null]]), api_response(null, 500)->getContent());

        $this->assertEquals(json_encode(['data' => null]), api_response('')->getContent());
        $this->assertEquals(json_encode(['data' => null]), api_response('', 300)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 400, 'data' => null]]), api_response('', 400)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 500, 'data' => null]]), api_response('', 500)->getContent());
    }

    public function testData()
    {
        $this->assertJson(api_response('ok')->getContent());
        $this->assertJson(api_response('fail', 400)->getContent());

        $this->assertEquals(json_encode(['data' => 'ok']), api_response('ok')->getContent());
    }

    public function testStructure()
    {
        $this->assertJsonStringEqualsJsonString(json_encode(['data' => 'ok']), api_response('ok')->getContent());
        $this->assertJsonStringEqualsJsonString(json_encode(['error' => ['code' => 400, 'data' => 'fail']]), api_response('fail', 400)->getContent());

        $this->assertJsonStringNotEqualsJsonString(json_encode(['data' => 'ok']), api_response('fail', 400)->getContent());
    }

    public function testDataWith()
    {
        $this->assertJson(api_response('ok', 200, ['foo' => 'bar'])->getContent());
        $this->assertJson(api_response('fail', 400, ['foo' => 'bar'])->getContent());

        $this->assertEquals(json_encode(['data' => 'ok', 'foo' => 'bar']), api_response('ok', 200, ['foo' => 'bar'])->getContent());

        $this->assertEquals(
            json_encode([
                'error' => [
                    'code' => 400,
                    'data' => 'ok',
                ],
                'foo'   => 'bar',
            ]),
            api_response('ok', 400, ['foo' => 'bar'])->getContent()
        );

        $this->assertEquals(
            json_encode(['data' => [], 'foo' => 'bar', 'baz' => 'baq']),
            api_response([], 200, ['foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq']),
            api_response([], 200, ['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => []], 'foo' => 'bar', 'baz' => 'baq']),
            api_response([], 400, ['foo' => 'bar', 'baz' => 'baq'])->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => []], 'data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq']),
            api_response([], 400, ['data' => ['foo' => 'foo', 'bar' => 'bar'], 'foo' => 'bar', 'baz' => 'baq'])->getContent()
        );
    }

    public function testNumber()
    {
        $this->assertEquals(json_encode(['data' => 304]), api_response(304)->getContent());
        $this->assertEquals(json_encode(['error' => ['code' => 400, 'data' => 304]]), api_response(304, 400)->getContent());
    }

    public function testStatusCode()
    {
        $this->assertEquals(200, api_response('ok')->getStatusCode());
        $this->assertEquals(301, api_response('ok', 301)->getStatusCode());
        $this->assertEquals(401, api_response('ok', 401)->getStatusCode());
        $this->assertEquals(500, api_response('ok', 500)->getStatusCode());
    }

    public function testKeyCollisionTesting()
    {
        $this->assertEquals(json_encode(['data' => 'example', 'foo' => 'bar']), api_response(['data' => 'example', 'foo' => 'bar'])->getContent());
        $this->assertEquals(json_encode(['data' => ['example', 'foo' => 'bar']]), api_response(['data' => ['example', 'foo' => 'bar']])->getContent());

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => 'example'], 'foo' => 'bar']),
            api_response(['data' => 'example', 'foo' => 'bar'], 400)->getContent()
        );

        $this->assertEquals(
            json_encode(['error' => ['code' => 400, 'data' => ['foo' => 'bar', 'baz' => 'baq']]]),
            api_response(['data' => ['foo' => 'bar', 'baz' => 'baq']], 400)->getContent()
        );
    }
}
