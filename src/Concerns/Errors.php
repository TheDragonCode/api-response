<?php

namespace DragonCode\ApiResponse\Concerns;

use DragonCode\Support\Facades\Helpers\Is;

trait Errors
{
    protected $is_error = false;

    public function isError(bool $ignore_status_code = false): bool
    {
        switch (true) {
            case $this->is_error:
            case $this->isErrorCode($this->status_code):
            case $this->isErrorStatusCode($ignore_status_code):
            case $this->isErrorContent():
            case $this->isErrorObject():
                return true;

            default:
                return false;
        }
    }

    protected function isErrorCode(int $code = null): bool
    {
        return $code === 0 || $code >= 400;
    }

    protected function isErrorContent(): bool
    {
        return is_array($this->data) && isset($this->data['error']);
    }

    protected function isErrorObject(): bool
    {
        return Is::error($this->data);
    }

    protected function isErrorStatusCode(bool $ignore_status_code = false): bool
    {
        if (! $ignore_status_code) {
            return $this->isErrorCode($this->resolveStatusCode());
        }

        return false;
    }

    protected function resolveStatusCode(): ?int
    {
        return method_exists($this, 'getStatusCode')
            ? $this->getStatusCode()
            : $this->status_code;
    }
}
