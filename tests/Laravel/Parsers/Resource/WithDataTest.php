<?php

namespace Tests\Laravel\Parsers\Resource;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Fixtures\Concerns\Resoursable;
use Tests\Fixtures\Contracts\Parserable;
use Tests\Fixtures\Laravel\Models\BarModel;
use Tests\Fixtures\Laravel\Models\FooModel;
use Tests\Fixtures\Laravel\Resources\Foo;
use Tests\Laravel\TestCase;

final class WithDataTest extends TestCase implements Parserable
{
    use Resoursable;

    public function testResponse()
    {
        $this->assertTrue($this->successResourceResponse()->instance() instanceof JsonResponse);
        $this->assertTrue($this->createdResourceResponse()->instance() instanceof JsonResponse);
        $this->assertTrue($this->failedResourceResponse()->instance() instanceof JsonResponse);
    }

    public function testJson()
    {
        $this->assertJson($this->successResourceResponse()->getRaw());
        $this->assertJson($this->createdResourceResponse()->getRaw());
        $this->assertJson($this->failedResourceResponse()->getRaw());
    }

    public function testStructure()
    {
        $this->assertSame(['data' => ['foo' => 'Foo', 'bar' => 'Bar'], 'baz' => 'Baz'], $this->successResourceResponse()->getJson());
        $this->assertSame(['data' => ['foo' => 'Foo', 'bar' => 'Bar'], 'baz' => 'Baz'], $this->createdResourceResponse()->getJson());

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => ['foo' => 'Foo', 'bar' => 'Bar']], 'baz' => 'Baz'],
            $this->failedResourceResponse()->getJson()
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

        $this->assertSame(['data' => ['foo' => 'Foo', 'bar' => ['qwerty' => 'Bar'], 'baz' => ['qwerty' => 'Bar']]], $response->getJson());
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
