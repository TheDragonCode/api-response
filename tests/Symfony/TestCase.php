<?php

namespace Tests\Symfony;

use Helldar\ApiResponse\Services\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Responsable;

abstract class TestCase extends BaseTestCase
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
