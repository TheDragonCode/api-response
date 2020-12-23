<?php

namespace Helldar\ApiResponse\Concerns;

use Helldar\Support\Facades\Is;

trait Errors
{
    protected $is_error = false;

    public function isError(): bool
    {
        switch (true) {
            case $this->is_error:
            case $this->isErrorCode():
            case $this->isErrorContent():
            case $this->isErrorObject():
                return true;

            default:
                return false;
        }
    }

    protected function isErrorCode(): bool
    {
        return $this->status_code === 0 || $this->status_code >= 400;
    }

    protected function isErrorContent(): bool
    {
        return is_array($this->data) && isset($this->data['error']);
    }

    protected function isErrorObject(): bool
    {
        return Is::error($this->data);
    }
}
