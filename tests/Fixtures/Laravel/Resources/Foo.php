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

namespace Tests\Fixtures\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Tests\Fixtures\Laravel\Models\FooModel */
class Foo extends JsonResource
{
    public function toArray($request)
    {
        return [
            'foo' => $this->foo,

            'bar' => Bar::make($this->bar),
            'baz' => Bar::make($this->whenLoaded('bar')),
        ];
    }
}
