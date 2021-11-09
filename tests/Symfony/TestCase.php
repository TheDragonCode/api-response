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

namespace Tests\Symfony;

use DragonCode\ApiResponse\Services\Response;
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
