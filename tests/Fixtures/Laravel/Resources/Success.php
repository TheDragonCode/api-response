<?php

namespace Tests\Fixtures\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Tests\Fixtures\Laravel\Models\Model */
final class Success extends JsonResource
{
    public function toArray($request)
    {
        return [
            'foo' => $this->foo,
            'bar' => $this->bar,
        ];
    }

    public function with($request)
    {
        return ['baz' => 'Baz'];
    }
}
