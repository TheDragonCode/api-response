<?php

namespace Tests\Symfony\Parsers\Main;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Symfony\TestCase;

final class NoWithDataTest extends TestCase
{
    protected $allow_with = false;

    public function testResponse()
    {
        $this->assertTrue($this->response()->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo')->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([])->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0)->instance() instanceof JsonResponse);

        $this->assertTrue($this->response(null, 200)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 200)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 200)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 200)->instance() instanceof JsonResponse);

        $this->assertTrue($this->response(null, 204)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 204)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 204)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 204)->instance() instanceof JsonResponse);

        $this->assertTrue($this->response(null, 300)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response('foo', 300)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response([], 300)->instance() instanceof JsonResponse);
        $this->assertTrue($this->response(0, 300)->instance() instanceof JsonResponse);
    }

    public function testJson()
    {
        $this->assertJson($this->response()->getRaw());
        $this->assertJson($this->response('foo')->getRaw());
        $this->assertJson($this->response([])->getRaw());
        $this->assertJson($this->response(0)->getRaw());

        $this->assertJson($this->response(null, 200)->getRaw());
        $this->assertJson($this->response('foo', 200)->getRaw());
        $this->assertJson($this->response([], 200)->getRaw());
        $this->assertJson($this->response(0, 200)->getRaw());

        $this->assertJson($this->response(null, 204)->getRaw());
        $this->assertJson($this->response('foo', 204)->getRaw());
        $this->assertJson($this->response([], 204)->getRaw());
        $this->assertJson($this->response(0, 204)->getRaw());

        $this->assertJson($this->response(null, 300)->getRaw());
        $this->assertJson($this->response('foo', 300)->getRaw());
        $this->assertJson($this->response([], 300)->getRaw());
        $this->assertJson($this->response(0, 300)->getRaw());
    }

    public function testStructure()
    {
        $this->assertSame(['data' => null], $this->response()->getJson());
        $this->assertSame(['data' => null], $this->response(null, 200)->getJson());
        $this->assertSame(['data' => null], $this->response(null, 204)->getJson());
        $this->assertSame(['data' => null], $this->response(null, 300)->getJson());

        $this->assertSame(['data' => 'foo'], $this->response('foo')->getJson());
        $this->assertSame(['data' => 'foo'], $this->response('foo', 200)->getJson());
        $this->assertSame(['data' => 'foo'], $this->response('foo', 204)->getJson());
        $this->assertSame(['data' => 'foo'], $this->response('foo', 300)->getJson());

        $this->assertSame(['data' => ['foo']], $this->response(['foo'])->getJson());
        $this->assertSame(['data' => ['foo']], $this->response(['foo'], 200)->getJson());
        $this->assertSame(['data' => ['foo']], $this->response(['foo'], 204)->getJson());
        $this->assertSame(['data' => ['foo']], $this->response(['foo'], 300)->getJson());

        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'])->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], 200)->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], 204)->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], 300)->getJson());

        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], null, ['bar' => 'Bar'])->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], 200, ['bar' => 'Bar'])->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], 204, ['bar' => 'Bar'])->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo']], $this->response(['foo' => 'Foo'], 300, ['bar' => 'Bar'])->getJson());

        $this->assertSame(['data' => []], $this->response([])->getJson());
        $this->assertSame(['data' => []], $this->response([], 200)->getJson());
        $this->assertSame(['data' => []], $this->response([], 204)->getJson());
        $this->assertSame(['data' => []], $this->response([], 300)->getJson());

        $this->assertSame(['data' => 0], $this->response(0)->getJson());
        $this->assertSame(['data' => 0], $this->response(0, 200)->getJson());
        $this->assertSame(['data' => 0], $this->response(0, 204)->getJson());
        $this->assertSame(['data' => 0], $this->response(0, 300)->getJson());
    }

    public function testStatusCode()
    {
        $this->assertSame(200, $this->response()->getStatusCode());
        $this->assertSame(200, $this->response('foo')->getStatusCode());
        $this->assertSame(200, $this->response([])->getStatusCode());
        $this->assertSame(200, $this->response(0)->getStatusCode());

        $this->assertSame(200, $this->response(null, 200)->getStatusCode());
        $this->assertSame(200, $this->response('foo', 200)->getStatusCode());
        $this->assertSame(200, $this->response([], 200)->getStatusCode());
        $this->assertSame(200, $this->response(0, 200)->getStatusCode());

        $this->assertSame(204, $this->response(null, 204)->getStatusCode());
        $this->assertSame(204, $this->response('foo', 204)->getStatusCode());
        $this->assertSame(204, $this->response([], 204)->getStatusCode());
        $this->assertSame(204, $this->response(0, 204)->getStatusCode());

        $this->assertSame(300, $this->response(null, 300)->getStatusCode());
        $this->assertSame(300, $this->response('foo', 300)->getStatusCode());
        $this->assertSame(300, $this->response([], 300)->getStatusCode());
        $this->assertSame(300, $this->response(0, 300)->getStatusCode());
    }
}
