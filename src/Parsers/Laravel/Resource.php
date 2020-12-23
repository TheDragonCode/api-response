<?php

namespace Helldar\ApiResponse\Parsers\Laravel;

use Helldar\ApiResponse\Parsers\Parser;
use Helldar\Support\Facades\Arr;

/**
 * @property \Illuminate\Http\Resources\Json\JsonResource $data
 */
final class Resource extends Parser
{
    public function getData()
    {
        return Arr::only($this->response(), ['data']);
    }

    public function getWith(): array
    {
        return Arr::except($this->response(), ['data']);
    }

    protected function response(): array
    {
        return $this->data->toResponse(
            $this->request()
        )->getData(true);
    }

    protected function request()
    {
        return app('request');
    }
}
