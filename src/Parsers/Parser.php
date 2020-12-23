<?php

namespace Helldar\ApiResponse\Parsers;

use Exception as BaseException;
use Helldar\ApiResponse\Contracts\Parseable;
use Helldar\Support\Facades\Instance;
use Helldar\Support\Facades\Is;
use Helldar\Support\Traits\Makeable;

abstract class Parser implements Parseable
{
    use Makeable;

    protected $is_error = false;

    protected $data;

    protected $status_code;

    public function isError(): bool
    {
        return $this->is_error || $this->isErrorCode() || Is::error($this->data);
    }

    public function setData($data): Parseable
    {
        $this->data = $data;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->isError() || $this->isErrorCode()
            ? ($this->status_code ?: 400)
            : ($this->status_code ?: 200);
    }

    public function setStatusCode(int $code = null): Parseable
    {
        $this->status_code = $code;

        return $this;
    }

    public function getType(): ?string
    {
        if ($this->isError()) {
            return Is::error($this->data) ? Instance::basename($this->data) : BaseException::class;
        }

        return null;
    }

    public function getWith(): array
    {
        return [];
    }

    protected function isErrorCode(): bool
    {
        return $this->status_code === 0 || $this->status_code >= 400;
    }
}
