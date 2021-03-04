<?php

namespace Tests\Fixtures\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Tests\Fixtures\Laravel\Models\BarModel */
class Bar extends JsonResource
{
    public function toArray($request)
    {
        return [
            'qwerty' => $this->bar,
        ];
    }

    public function with($request)
    {
        return ['baz' => 'Baz'];
    }
}
