<?php

namespace Tests\Laravel;

use Helldar\ApiResponse\Services\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Laravel\Application;
use Tests\Fixtures\Concerns\Laravel\Exceptionable;
use Tests\Fixtures\Concerns\Responsable;
use Tests\Fixtures\Contracts\Testable;
use Tests\Fixtures\Laravel\Exceptions\EightHandler;
use Tests\Fixtures\Laravel\Exceptions\SevenHandler;

abstract class TestCase extends BaseTestCase implements Testable
{
    use Application;
    use Responsable;
    use Exceptionable;

    protected $hide = true;

    protected $wrap = true;

    protected $with = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setHidePrivate();
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

    protected function setHidePrivate(): void
    {
        Response::hidePrivate($this->hide);
    }

    protected function setWrapping(): void
    {
        $this->wrap
            ? Response::wrapped()
            : Response::withoutWrap();
    }

    protected function setWithable(): void
    {
        $this->with
            ? Response::allowWith()
            : Response::withoutWith();
    }

    protected function getExceptionHandler(): string
    {
        switch (true) {
            case $this->isSeven():
                return SevenHandler::class;

            default:
                return EightHandler::class;
        }
    }
}
