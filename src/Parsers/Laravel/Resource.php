<?php

namespace Helldar\ApiResponse\Parsers\Laravel;

use Helldar\ApiResponse\Parsers\Parser;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Http\JsonResponse;

/** @property \Illuminate\Http\Resources\Json\JsonResource $data */
final class Resource extends Parser
{
    public function getData()
    {
        $data = $this->resourceData();

        return $this->hasData($data)
            ? Arr::only($data, ['data'])
            : $data;
    }

    public function getWith(): array
    {
        $data = $this->resourceData();

        return $this->hasData($data)
            ? Arr::except($data, ['data'])
            : [];
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

    protected function hasData($data): bool
    {
        return isset($data['data']);
    }

    protected function request()
    {
        return app('request');
    }
}
