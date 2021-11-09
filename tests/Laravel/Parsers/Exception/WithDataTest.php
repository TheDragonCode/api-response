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

namespace Tests\Laravel\Parsers\Exception;

use Tests\Fixtures\Concerns\Laravel\Requests;
use Tests\Laravel\TestCase;

class WithDataTest extends TestCase
{
    use Requests;

    public function testJson()
    {
        $response = $this->requestBar();

        $this->assertJson($response->getRaw());
    }

    public function testStructure()
    {
        $response = $this->requestBar();

        $this->assertSame(
            ['error' => ['type' => 'Exception', 'data' => 'Foo Bar']],
            $response->getJson()
        );
    }

    public function testStatusCode()
    {
        $response = $this->requestBar();

        $this->assertSame(500, $response->getStatusCode());
    }
}
