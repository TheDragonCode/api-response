<?php

namespace Tests\Laravel\Parsers\Resource;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Fixtures\Concerns\Resoursable;
use Tests\Fixtures\Laravel\Models\BarModel;
use Tests\Fixtures\Laravel\Models\FooModel;
use Tests\Fixtures\Laravel\Resources\Foo;
use Tests\Laravel\TestCase;

final class NoWithNoDataNoHideTest extends TestCase
{
    use Resoursable;

    protected $hide = false;

    protected $with = false;

    protected $wrap = false;

    public function testInstance()
    {
        $this->assertTrue($this->successResourceResponse()->instance() instanceof JsonResponse);
        $this->assertTrue($this->createdResourceResponse()->instance() instanceof JsonResponse);
        $this->assertTrue($this->failedResourceResponse()->instance() instanceof JsonResponse);
    }

    public function testType()
    {
        $this->assertJson($this->successResourceResponse()->getRaw());
        $this->assertJson($this->createdResourceResponse()->getRaw());
        $this->assertJson($this->failedResourceResponse()->getRaw());
    }

    public function testStructureSuccess()
    {
        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $this->successResourceResponse()->getJson());
        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $this->createdResourceResponse()->getJson());
    }

    public function testStructureErrors()
    {
        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo', 'bar' => 'Bar']]],
            $this->failedResourceResponse()->getJson()
        );

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo', 'bar' => 'Bar']]],
            $this->failedResourceResponse(502)->getJson()
        );
    }

    public function testSubresources()
    {
        $foo = new FooModel();
        $bar = new BarModel();

        $foo->setRelation('bar', $bar);

        $resource = Foo::make($foo);

        $response = $this->response($resource);

        $this->assertTrue($response->instance() instanceof JsonResponse);
        $this->assertJson($response->getRaw());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertSame(['foo' => 'Foo', 'bar' => ['qwerty' => 'Bar']], $response->getJson());
    }

    public function testSubresourcesWithExtra()
    {
        $foo = new FooModel();
        $bar = new BarModel();

        $foo->setRelation('bar', $bar);

        $resource = Foo::make($foo);

        $response = $this->response($resource, null, ['pro' => 'Pro']);

        $this->assertTrue($response->instance() instanceof JsonResponse);
        $this->assertJson($response->getRaw());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertSame(['foo' => 'Foo', 'bar' => ['qwerty' => 'Bar']], $response->getJson());
    }

    public function testStatusCode()
    {
        $this->assertSame(200, $this->successResourceResponse()->getStatusCode());
        $this->assertSame(201, $this->createdResourceResponse()->getStatusCode());
        $this->assertSame(401, $this->failedResourceResponse()->getStatusCode());

        $this->assertSame(300, $this->successResourceResponse(300)->getStatusCode());
        $this->assertSame(301, $this->createdResourceResponse(301)->getStatusCode());
        $this->assertSame(403, $this->failedResourceResponse(403)->getStatusCode());
    }
}
