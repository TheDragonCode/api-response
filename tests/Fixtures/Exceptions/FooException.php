<?php

namespace Tests\Fixtures\Exceptions;

use Exception;

class FooException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 405);
    }
}
