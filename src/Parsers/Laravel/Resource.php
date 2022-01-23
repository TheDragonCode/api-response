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

namespace DragonCode\ApiResponse\Parsers\Laravel;

use DragonCode\ApiResponse\Parsers\Parser;
use DragonCode\Support\Facades\Helpers\Ables\Arrayable;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Http\JsonResponse;

/** @property \Illuminate\Http\Resources\Json\JsonResource $data */
class Resource extends Parser
{
    public function getData(): array
    {
        $data = $this->resourceData();

        if ($this->hasData($data)) {
            return Arr::only($data, ['data']);
        }

        return $data;
    }

    public function getWith(): array
    {
        $data = $this->resourceData();

        if ($this->hasData($data)) {
            return Arrayable::of($data)
                ->except('data')
                ->merge($this->with)
                ->get();
        }

        return $this->with;
    }

    public function getStatusCode(): int
    {
        return $this->status_code ?: ($this->response()->getStatusCode() ?: parent::getStatusCode());
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
