<?php

namespace Tests\Laravel\Parsers\Validation;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Fixtures\Concerns\Validationable;
use Tests\Laravel\TestCase;

final class NoWithNoDataNoHideTest extends TestCase
{
    use Validationable;

    protected $hide = false;

    protected $with = false;

    protected $wrap = false;

    public function testInstance()
    {
        $this->assertTrue($this->validationResponse(['foo' => 'Foo', 'bar' => 123])->instance() instanceof JsonResponse);
        $this->assertTrue($this->validationResponse([])->instance() instanceof JsonResponse);
    }

    public function testType()
    {
        $this->assertJson($this->validationResponse(['foo' => 'Foo', 'bar' => 123])->getRaw());
        $this->assertJson($this->validationResponse([])->getRaw());
    }

    public function testStructureSuccess()
    {
        $this->assertSame(
            ['foo' => 'Foo', 'bar' => 123],
            $this->validationResponse(['foo' => 'Foo', 'bar' => 123])->getJson()
        );

        $this->assertSame(
            ['foo' => 456, 'bar' => 123],
            $this->validationResponse(['foo' => 456, 'bar' => 123])->getJson()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'bar' => 123, 'baz' => 'http://foo.bar'],
            $this->validationResponse(['foo' => 'Foo', 'bar' => 123, 'baz' => 'http://foo.bar'])->getJson()
        );

        $this->assertSame(
            ['foo' => 456, 'bar' => 123, 'baz' => 'http://foo.bar'],
            $this->validationResponse(['foo' => 456, 'bar' => 123, 'baz' => 'http://foo.bar'])->getJson()
        );
    }

    public function testStructureErrors()
    {
        $this->assertSame(
            ['error' => ['type' => 'ValidationException', 'data' => ['foo' => ['The foo field is required.']]]],
            $this->validationResponse([])->getJson()
        );

        $this->assertSame(
            [
                'error' => [
                    'type' => 'ValidationException',
                    'data' => [
                        'foo' => ['The foo field is required.'],
                        'baz' => ['The baz format is invalid.'],
                    ],
                ],
            ],
            $this->validationResponse(['baz' => 0])->getJson()
        );

        $this->assertSame(
            [
                'error' => [
                    'type' => 'ValidationException',
                    'data' => [
                        'foo' => ['The foo field is required.'],
                        'bar' => ['The bar must be an integer.'],
                        'baz' => ['The baz format is invalid.'],
                    ],
                ],
            ],
            $this->validationResponse(['bar' => 'Bar', 'baz' => 0])->getJson()
        );
    }

    public function testStatusCode()
    {
        $this->assertSame(200, $this->validationResponse(['foo' => 'Foo', 'bar' => 123])->getStatusCode());
        $this->assertSame(200, $this->validationResponse(['foo' => 456, 'bar' => 123])->getStatusCode());
        $this->assertSame(422, $this->validationResponse([])->getStatusCode());

        $this->assertSame(202, $this->validationResponse(['foo' => 'Foo', 'bar' => 123], 202)->getStatusCode());
        $this->assertSame(203, $this->validationResponse(['foo' => 456, 'bar' => 123], 203)->getStatusCode());
        $this->assertSame(401, $this->validationResponse([], 401)->getStatusCode());
    }
}
