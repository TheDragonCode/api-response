<?php

namespace Tests\Fixtures\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class Created extends JsonResource
{
    public function withResponse($request, $response)
    {
        $response->setStatusCode(201);
    }
}
