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

namespace Tests\Fixtures\Entities;

use Illuminate\Contracts\Support\Arrayable as Contract;

class Arrayable implements Contract
{
    public function foo(): string
    {
        return 'foo';
    }

    public function toArray()
    {
        return [
            'values' => [
                'value' => $this->foo(),
            ],
        ];
    }
}
