<?php

namespace Helldar\ApiResponse\Parsers\Laravel;

use Helldar\ApiResponse\Parsers\Parser;

/** @property \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException $data */
final class MaintenanceMode extends Parser
{
    public function getData()
    {
        return [
            'retry_after' => $this->date('retryAfter'),
            'message'     => $this->message(),
        ];
    }

    public function getStatusCode(): int
    {
        return $this->status_code ?: $this->data->getStatusCode() ?? parent::getStatusCode();
    }

    protected function date(string $key): ?int
    {
        if (isset($this->data->{$key})) {
            return $this->data->{$key};
        }

        return null;
    }

    protected function message(): string
    {
        return $this->data->getMessage();
    }
}
