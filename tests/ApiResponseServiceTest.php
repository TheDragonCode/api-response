<?php

namespace Helldar\ApiResponse\Tests;

use Helldar\ApiResponse\Services\ApiResponseService;
use PHPUnit\Framework\TestCase;

class ApiResponseServiceTest extends TestCase
{
    public function testInit()
    {
        $instance = ApiResponseService::init();

        $this->assertEquals($instance instanceof ApiResponseService, true);
    }
}
