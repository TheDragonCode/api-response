<?php

namespace Tests\Fixtures\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class FooHttpException extends HttpException
{
    public function __construct(string $message, int $status_code = 403)
    {
        parent::__construct($status_code, $message);
    }
}
