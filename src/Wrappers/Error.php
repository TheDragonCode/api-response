<?php

namespace DragonCode\ApiResponse\Wrappers;

class Error extends Wrapper
{
    protected $message = 'Whoops! Something went wrong.';

    protected function response()
    {
        return [
            'error' => [
                'type' => $this->getType(),
                'data' => $this->resolveData(),
            ],
        ];
    }

    /**
     * @return array|int|string|null
     */
    protected function resolveData()
    {
        return $this->hideMessage()
            ? $this->defaultErrorMessage()
            : $this->defaultErrorMessage($this->data);
    }

    /**
     * @param  mixed  $message
     *
     * @return array|int|string|null
     */
    protected function defaultErrorMessage($message = null)
    {
        if (empty($message) || $message === 'Server Error') {
            return $this->message;
        }

        return $message;
    }

    protected function isHttpError(): bool
    {
        $code = $this->statusCode();

        return $code >= 400 && $code < 500;
    }

    protected function hideMessage(): bool
    {
        return ! $this->allow_with && ! $this->isHttpError();
    }
}
