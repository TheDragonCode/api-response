<?php

namespace Tests\Laravel;

use Helldar\ApiResponse\Services\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Responsable;

class TestCase extends BaseTestCase
{
    use Responsable;

    protected $wrap = true;

    protected $allow_with = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setWrapping();
        $this->setWithable();
    }

    protected function setWrapping(): void
    {
        $this->wrap
            ? JsonResource::wrap('data')
            : JsonResource::withoutWrapping();

        $this->wrap
            ? Response::wrapped()
            : Response::withoutWrap();
    }

    protected function setWithable(): void
    {
        $this->allow_with
            ? Response::allowWith()
            : Response::withoutWith();
    }
}
