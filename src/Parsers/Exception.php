<?php

namespace Helldar\ApiResponse\Parsers;

use Exception as BaseException;
use Helldar\Support\Facades\Helpers\Call;
use Helldar\Support\Facades\Helpers\Instance;
use Throwable;

/**
 * @property \Exception|\Throwable $data
 */
final class Exception extends Parser
{
    protected $is_error = true;

    public function getData()
    {
        if ($data = $this->getThrowableContent()) {
            return $data;
        }

        return $this->data;
    }

    public function getStatusCode(): int
    {
        if ($this->isErrorCode($this->status_code)) {
            return $this->status_code;
        }

        return Call::runMethods($this->data, ['getStatusCode', 'getCode']) ?: 400;
    }

    /**
     * @return array|int|string|null
     */
    protected function getThrowableContent()
    {
        return Instance::of($this->data, [BaseException::class, Throwable::class])
            ? Call::runMethods($this->data, ['getOriginalContent', 'getContent', 'getResponse', 'getMessage'])
            : null;
    }
}
