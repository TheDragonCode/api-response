<?php

namespace Tests\Fixtures\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Tests\Fixtures\Laravel\Model */
final class Created extends JsonResource
{
    public function withResponse($request, $response)
    {
        $response->setStatusCode(201);
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
