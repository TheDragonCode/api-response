<?php

namespace Tests\Exceptions;

namespace Tests\Exceptions;

use Exception;

final class BarException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 0);
    }
}
