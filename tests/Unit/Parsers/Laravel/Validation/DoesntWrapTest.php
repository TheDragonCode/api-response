<?php

namespace Tests\Unit\Parsers\Laravel\Validation;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Throwable;

final class DoesntWrapTest extends TestCase
{
    protected $wrap = false;

    public function testThrow()
    {
        try {
            Validator::make([], [
                'foo' => ['required'],
                'bar' => ['required'],
            ])->validate();
        } catch (Throwable $e) {
            $response = $this->response($e);

            $this->assertSame(422, $response->getStatusCode());

            $this->assertSame(json_encode([
                'error' => [
                    'type' => 'ValidationException',
                    'data' => [
                        'foo' => ['The foo field is required.'],
                        'bar' => ['The bar field is required.'],
                    ],
                ],
            ]), $response->getContent());
        }
    }
}
