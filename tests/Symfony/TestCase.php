<?php

namespace Tests\Symfony;

use Helldar\ApiResponse\Services\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Responsable;
use Tests\Fixtures\Contracts\Testable;

abstract class TestCase extends BaseTestCase implements Testable
{
    use Responsable;

    protected $hide = true;

    protected $wrap = true;

    protected $allow_with = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setHidePrivate();
        $this->setWrapping();
        $this->setWithable();
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
        $this->allow_with
            ? Response::allowWith()
            : Response::withoutWith();
    }
}
