<?php

namespace Tests\Laravel;

use Helldar\ApiResponse\Services\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Responsable;
use Tests\Fixtures\Laravel\Model;
use Tests\Fixtures\Laravel\Resources\Created;
use Tests\Fixtures\Laravel\Resources\Success;

class TestCase extends BaseTestCase
{
    use Responsable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setWrapping();
    }

    protected function laravelModel(): Model
    {
        return new Model();
    }

    protected function successResource(): Success
    {
        return Success::make($this->laravelModel());
    }

    protected function createdResource(): Created
    {
        return Created::make($this->laravelModel());
    }

    protected function setWrapping(): void
    {
        $this->wrap
            ? JsonResource::wrap('data')
            : JsonResource::withoutWrapping();

        $this->wrap
            ? Response::allowWith()
            : Response::withoutWith();
    }
}
