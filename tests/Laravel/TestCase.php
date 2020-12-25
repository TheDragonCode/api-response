<?php

namespace Tests\Laravel;

use Helldar\ApiResponse\Services\Response;
use Helldar\Support\Facades\Str;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\JsonResource;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Laravel\Maintenance;
use Tests\Fixtures\Concerns\Responsable;
use Tests\Fixtures\Laravel\Exceptions\NewHandler;
use Tests\Fixtures\Laravel\Exceptions\OldHandler;

class TestCase extends BaseTestCase
{
    use Responsable;
    use Maintenance;

    protected $wrap = true;

    protected $allow_with = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setWrapping();
        $this->setWithable();
    }

    protected function tearDown(): void
    {
        $this->removeDownFile();

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setRoutes($app);
    }

    protected function resolveApplicationExceptionHandler($app)
    {
        $app->singleton(ExceptionHandler::class, $this->getExceptionHandler());
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

    protected function getExceptionHandler(): string
    {
        return Str::startsWith(Application::VERSION, '6.') ? OldHandler::class : NewHandler::class;
    }
}
