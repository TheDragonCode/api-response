<?php

namespace Helldar\ApiResponse\Wrappers;

final class Error extends Wrapper
{
    protected function response()
    {
        return [
            'error' => [
                'type' => $this->getType(),
                'data' => $this->data,
            ],
        ];
    }
}
