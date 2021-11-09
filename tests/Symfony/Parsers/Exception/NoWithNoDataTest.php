<?php

namespace Tests\Symfony\Parsers\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Symfony\TestCase;

class NoWithNoDataTest extends TestCase
{
    protected $wrap = false;

    protected $allow_with = false;

    public function testResponse()
    {
        $this->assertTrue($this->response(null, 0)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 0)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 0)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 0)->instance() instanceof JsonResponse);

        $this->assertTrue($this->response(null, 400)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 400)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 400)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 400)->instance() instanceof JsonResponse);

        $this->assertTrue($this->response(null, 404)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 404)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 404)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 404)->instance() instanceof JsonResponse);

        $this->assertTrue($this->response(null, 500)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 500)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 500)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 500)->instance() instanceof JsonResponse);
    }

    public function testJson()
    {
        $this->assertJson($this->response(null, 0)->getRaw());
        $this->assertJson($this->response('foo', 0)->getRaw());
        $this->assertJson($this->response([], 0)->getRaw());
        $this->assertJson($this->response(0, 0)->getRaw());

        $this->assertJson($this->response(null, 400)->getRaw());
        $this->assertJson($this->response('foo', 400)->getRaw());
        $this->assertJson($this->response([], 400)->getRaw());
        $this->assertJson($this->response(0, 400)->getRaw());

        $this->assertJson($this->response(null, 404)->getRaw());
        $this->assertJson($this->response('foo', 404)->getRaw());
        $this->assertJson($this->response([], 404)->getRaw());
        $this->assertJson($this->response(0, 404)->getRaw());

        $this->assertJson($this->response(null, 500)->getRaw());
        $this->assertJson($this->response('foo', 500)->getRaw());
        $this->assertJson($this->response([], 500)->getRaw());
        $this->assertJson($this->response(0, 500)->getRaw());
    }

    public function testStructure()
    {
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(null, 0)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(null, 400)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(null, 404)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(null, 500)->getJson());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response([], 0)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response([], 400)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response([], 404)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response([], 500)->getJson());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response('foo', 0)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'foo']], $this->response('foo', 400)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'foo']], $this->response('foo', 404)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response('foo', 500)->getJson());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(['foo'], 0)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo']]], $this->response(['foo'], 400)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo']]], $this->response(['foo'], 404)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(['foo'], 500)->getJson());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(['foo' => 'Foo'], 0)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']]], $this->response(['foo' => 'Foo'], 400)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']]], $this->response(['foo' => 'Foo'], 404)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(['foo' => 'Foo'], 500)->getJson());

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(0, 0)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(0, 400)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(0, 404)->getJson());
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']], $this->response(0, 500)->getJson());

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']],
            $this->response(['foo' => 'Foo'], 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']]],
            $this->response(['foo' => 'Foo'], 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']]],
            $this->response(['foo' => 'Foo'], 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.']],
            $this->response(['foo' => 'Foo'], 500, ['bar' => 'Bar'])->getJson()
        );
    }

    public function testStatusCode()
    {
        $this->assertSame(500, $this->response(null, 0)->getStatusCode());
        $this->assertSame(500, $this->response('foo', 0)->getStatusCode());
        $this->assertSame(500, $this->response([], 0)->getStatusCode());
        $this->assertSame(500, $this->response(0, 0)->getStatusCode());

        $this->assertSame(400, $this->response(null, 400)->getStatusCode());
        $this->assertSame(400, $this->response('foo', 400)->getStatusCode());
        $this->assertSame(400, $this->response([], 400)->getStatusCode());
        $this->assertSame(400, $this->response(0, 400)->getStatusCode());

        $this->assertSame(404, $this->response(null, 404)->getStatusCode());
        $this->assertSame(404, $this->response('foo', 404)->getStatusCode());
        $this->assertSame(404, $this->response([], 404)->getStatusCode());
        $this->assertSame(404, $this->response(0, 404)->getStatusCode());

        $this->assertSame(500, $this->response(null, 500)->getStatusCode());
        $this->assertSame(500, $this->response('foo', 500)->getStatusCode());
        $this->assertSame(500, $this->response([], 500)->getStatusCode());
        $this->assertSame(500, $this->response(0, 500)->getStatusCode());
    }
}
