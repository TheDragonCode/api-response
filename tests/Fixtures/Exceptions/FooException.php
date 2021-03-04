<?php

namespace Tests\Fixtures\Exceptions;

use Exception;

final class FooException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 502);
    }
}
