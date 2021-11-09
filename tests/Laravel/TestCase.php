<?php

/*
 * This file is part of the "dragon-code/api-response" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/api-response
 */

namespace Tests\Laravel;

use DragonCode\ApiResponse\Services\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Laravel\Application;
use Tests\Fixtures\Concerns\Laravel\Exceptionable;
use Tests\Fixtures\Concerns\Responsable;
use Tests\Fixtures\Laravel\Exceptions\EightHandler;
use Tests\Fixtures\Laravel\Exceptions\SevenHandler;

class TestCase extends BaseTestCase
{
    use Application;
    use Responsable;
    use Exceptionable;

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
        switch (true) {
            case $this->isSeven():
                return SevenHandler::class;

            default:
                return EightHandler::class;
        }
    }
}
