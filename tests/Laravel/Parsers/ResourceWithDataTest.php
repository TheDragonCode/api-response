<?php

namespace Tests\Laravel\Parsers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Fixtures\Concerns\Resoursable;
use Tests\Fixtures\Contracts\Parserable;
use Tests\Laravel\TestCase;

final class ResourceWithDataTest extends TestCase implements Parserable
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

    public function testStatusCode()
    {
        $this->assertSame(200, $this->successResourceResponse()->getStatusCode());
        $this->assertSame(201, $this->createdResourceResponse()->getStatusCode());
        $this->assertSame(401, $this->failedResourceResponse()->getStatusCode());
    }
}
