<?php

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
        ];
    }

    public function with($request)
    {
        return [
            'baz' => Bar::make($this->whenLoaded('bar')),
        ];
    }
}
