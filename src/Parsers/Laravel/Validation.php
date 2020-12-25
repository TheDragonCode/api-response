<?php

namespace Helldar\ApiResponse\Parsers\Laravel;

use Helldar\ApiResponse\Parsers\Parser;

/**
 * @property \Illuminate\Validation\ValidationException $data
 */
final class Validation extends Parser
{
    public function getData()
    {
        return ['data' => $this->data->errors()];
    }

    public function getStatusCode(): int
    {
        return $this->status_code ?: $this->data->status ?? parent::getStatusCode();
    }
}
