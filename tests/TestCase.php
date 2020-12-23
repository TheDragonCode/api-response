<?php

namespace Tests;

use Illuminate\Http\Resources\Json\JsonResource;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Entities\Response;
use Tests\Fixtures\Laravel\Model;
use Tests\Fixtures\Laravel\Resources\Created;
use Tests\Fixtures\Laravel\Resources\Success;

abstract class TestCase extends BaseTestCase
{
    protected $wrap = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->laravelResourceWrapping();
    }

    protected function response($data = null, int $status_code = 200, array $with = []): Response
    {
        return new Response($data, $status_code, $with, [], $this->wrap);
    }

    protected function laravelModel(): Model
    {
        return new Model();
    }

    protected function laravelSuccessResource(): Success
    {
        return Success::make($this->laravelModel());
    }

    protected function laravelCreatedResource(): Created
    {
        return Created::make($this->laravelModel());
    }

    protected function laravelResourceWrapping(): void
    {
        $this->wrap
            ? JsonResource::wrap('data')
            : JsonResource::withoutWrapping();
    }
}
