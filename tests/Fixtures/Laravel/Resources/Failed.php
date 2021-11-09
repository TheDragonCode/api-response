<?php

namespace Tests\Fixtures\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Tests\Fixtures\Laravel\Models\Model */
class Failed extends JsonResource
{
    public function withResponse($request, $response)
    {
        $response->setStatusCode(401);
    }

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
