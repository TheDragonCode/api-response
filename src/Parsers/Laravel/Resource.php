<?php

namespace Helldar\ApiResponse\Parsers\Laravel;

use Helldar\ApiResponse\Parsers\Parser;
use Helldar\Support\Facades\Arr;
use Illuminate\Http\JsonResponse;

/**
 * @property \Illuminate\Http\Resources\Json\JsonResource $data
 */
final class Resource extends Parser
{
    public function getData()
    {
        return Arr::only($this->resourceData(), ['data']);
    }

    public function getWith(): array
    {
        return Arr::except($this->resourceData(), ['data']);
    }

    public function getStatusCode(): int
    {
        return $this->status_code ?: $this->response()->getStatusCode() ?: parent::getStatusCode();
    }

    protected function response(): JsonResponse
    {
        return $this->data->toResponse(
            $this->request()
        );
    }

    protected function resourceData(): array
    {
        return $this->response()->getData(true);
    }

    protected function request()
    {
        return app('request');
    }
}
