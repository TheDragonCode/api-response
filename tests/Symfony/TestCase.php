<?php

namespace Tests\Symfony;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Fixtures\Concerns\Responsable;

abstract class TestCase extends BaseTestCase
{
    use Responsable;

    protected $wrap = true;
}
