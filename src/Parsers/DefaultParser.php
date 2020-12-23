<?php

namespace Helldar\ApiResponse\Parsers;

final class DefaultParser extends Parser
{
    public function getData()
    {
        return $this->data;
    }
}
