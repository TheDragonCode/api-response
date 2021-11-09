<?php

namespace DragonCode\ApiResponse\Parsers\Laravel;

use DragonCode\ApiResponse\Parsers\Parser;

/** @property \Illuminate\Validation\ValidationException $data */
class Validation extends Parser
{
    public function getData()
    {
        return ['data' => $this->data->errors()];
    }

    public function getStatusCode(): int
    {
        return $this->status_code ?: ($this->data->status ?? parent::getStatusCode());
    }
}
