<?php

namespace Helldar\ApiResponse\Parsers;

use Exception as BaseException;
use Helldar\Support\Facades\Helpers\Instance;
use Throwable;

/** @property \Exception|\Throwable $data */
final class Exception extends Parser
{
    protected $is_error = true;

    public function getData()
    {
        return $this->getThrowableContent() ?: $this->data;
    }

    public function getStatusCode(): int
    {
        if ($this->isErrorCode($this->status_code)) {
            return $this->status_code;
        }

        return $this->callStatusCode() ?: parent::getStatusCode();
    }

    /**
     * @return array|int|string|null
     */
    protected function getThrowableContent()
    {
        return $this->isThrowable() ? $this->callContent() : null;
    }

    protected function callStatusCode(): ?int
    {
        return $this->call(['getStatusCode', 'getCode']);
    }

    protected function callContent()
    {
        return $this->call(['getOriginalContent', 'getContent', 'getResponse', 'getMessage']);
    }

    protected function isThrowable(): bool
    {
        return Instance::of($this->data, [BaseException::class, Throwable::class]);
    }

    protected function call(array $methods)
    {
        return Instance::callWhen($this->data, $methods);
    }
}
