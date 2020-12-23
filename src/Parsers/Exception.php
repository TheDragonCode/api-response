<?php

namespace Helldar\ApiResponse\Parsers;

use Exception as BaseException;
use Helldar\Support\Facades\Instance;
use Throwable;

/**
 * @property \Exception|\Throwable $data
 */
final class Exception extends Parser
{
    protected $is_error = true;

    protected $message = 'Whoops! Something went wrong.';

    public function getData()
    {
        if ($data = $this->getThrowableContent()) {
            return $this->message($data);
        }

        return $this->message($this->data);
    }

    public function getStatusCode(): int
    {
        if ($this->isErrorCode()) {
            return $this->status_code;
        }

        if ($code = Instance::callsWhenNotEmpty($this->data, ['getStatusCode', 'getCode'], 400)) {
            return $code;
        }

        return parent::getStatusCode();
    }

    protected function getThrowableContent()
    {
        return Instance::of($this->data, [BaseException::class, Throwable::class])
            ? Instance::callsWhenNotEmpty($this->data, ['getOriginalContent', 'getContent', 'getResponse', 'getMessage'])
            : null;
    }

    protected function message($data): string
    {
        return $data ?: $this->message;
    }
}
