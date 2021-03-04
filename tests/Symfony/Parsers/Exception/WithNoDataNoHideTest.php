<?php

namespace Tests\Symfony\Parsers\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Symfony\TestCase;

final class WithNoDataNoHideTest extends TestCase
{
    protected $hide = false;

    protected $wrap = false;

    public function testInstance()
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

    public function testType()
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

    public function testStructureSuccess()
    {
        $this->assertSame([], $this->response(null, null, ['bar' => 'Bar'])->getJson());
        $this->assertSame('foo', $this->response('foo', null, ['bar' => 'Bar'])->getJson());
        $this->assertSame([], $this->response([], null, ['bar' => 'Bar'])->getJson());
        $this->assertSame(0, $this->response(0, null, ['bar' => 'Bar'])->getJson());

        $this->assertSame([], $this->response(null, 200, ['bar' => 'Bar'])->getJson());
        $this->assertSame('foo', $this->response('foo', 200, ['bar' => 'Bar'])->getJson());
        $this->assertSame([], $this->response([], 200, ['bar' => 'Bar'])->getJson());
        $this->assertSame(0, $this->response(0, 200, ['bar' => 'Bar'])->getJson());

        $this->assertSame([], $this->response(null, 300, ['bar' => 'Bar'])->getJson());
        $this->assertSame('foo', $this->response('foo', 300, ['bar' => 'Bar'])->getJson());
        $this->assertSame([], $this->response([], 300, ['bar' => 'Bar'])->getJson());
        $this->assertSame(0, $this->response(0, 300, ['bar' => 'Bar'])->getJson());
    }

    public function testStructureErrors()
    {
        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(null, 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(null, 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(null, 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(null, 500, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response([], 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response([], 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response([], 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response([], 500, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response('foo', 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'foo'], 'bar' => 'Bar'],
            $this->response('foo', 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'foo'], 'bar' => 'Bar'],
            $this->response('foo', 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response('foo', 500, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(['foo'], 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo']], 'bar' => 'Bar'],
            $this->response(['foo'], 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo']], 'bar' => 'Bar'],
            $this->response(['foo'], 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(['foo'], 500, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 500, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(0, 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(0, 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(0, 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(0, 500, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 0, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 400, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo']], 'bar' => 'Bar'],
            $this->response(['foo' => 'Foo'], 404, ['bar' => 'Bar'])->getJson()
        );

        $this->assertSame(['error' => ['type' => 'Exception', 'data' => 'Whoops! Something went wrong.'], 'bar' => 'Bar'],
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
