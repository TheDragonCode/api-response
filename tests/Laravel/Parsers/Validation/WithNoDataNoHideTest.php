<?php

namespace Tests\Laravel\Parsers\Validation;

use Helldar\Support\Facades\Helpers\Arr;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\Fixtures\Concerns\Validationable;
use Tests\Laravel\TestCase;

final class WithNoDataNoHideTest extends TestCase
{
    use Validationable;

    protected $hide = false;

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
            ['data' => ['foo' => 'Foo', 'bar' => 123]],
            $this->validationResponse(['foo' => 'Foo', 'bar' => 123])->getJson()
        );

        $this->assertSame(
            ['data' => ['foo' => 456, 'bar' => 123]],
            $this->validationResponse(['foo' => 456, 'bar' => 123])->getJson()
        );

        $this->assertSame(
            ['data' => ['foo' => 'Foo', 'bar' => 123, 'baz' => 'http://foo.bar']],
            $this->validationResponse(['foo' => 'Foo', 'bar' => 123, 'baz' => 'http://foo.bar'])->getJson()
        );

        $this->assertSame(
            ['data' => ['foo' => 456, 'bar' => 123, 'baz' => 'http://foo.bar']],
            $this->validationResponse(['foo' => 456, 'bar' => 123, 'baz' => 'http://foo.bar'])->getJson()
        );
    }

    public function testStructureErrors()
    {
        /*
         * FOO
         */
        $foo = $this->validationResponse([])->getJson();

        $this->assertSame(
            ['error' => ['type' => 'ValidationException', 'data' => ['foo' => ['The foo field is required.']]]],
            Arr::only($foo, 'error')
        );

        $this->assertArrayHasKey('error', $foo);
        $this->assertArrayHasKey('exception', $foo);
        $this->assertArrayHasKey('file', $foo);
        $this->assertArrayHasKey('line', $foo);
        $this->assertArrayHasKey('trace', $foo);

        /*
         * BAR
         */
        $bar = $this->validationResponse(['baz' => 0])->getJson();

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
            Arr::only($bar, 'error')
        );

        $this->assertArrayHasKey('error', $bar);
        $this->assertArrayHasKey('exception', $bar);
        $this->assertArrayHasKey('file', $bar);
        $this->assertArrayHasKey('line', $bar);
        $this->assertArrayHasKey('trace', $bar);

        /*
         * BAZ
         */
        $baz = $this->validationResponse(['bar' => 'Bar', 'baz' => 0])->getJson();

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
            Arr::only($baz, 'error')
        );

        $this->assertArrayHasKey('error', $baz);
        $this->assertArrayHasKey('exception', $baz);
        $this->assertArrayHasKey('file', $baz);
        $this->assertArrayHasKey('line', $baz);
        $this->assertArrayHasKey('trace', $baz);
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
