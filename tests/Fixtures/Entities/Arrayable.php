<?php

namespace Tests\Fixtures\Entities;

use Illuminate\Contracts\Support\Arrayable as Contract;

class Arrayable implements Contract
{
    public function foo(): string
    {
        return 'foo';
    }

    public function toArray()
    {
        return [
            'values' => [
                'value' => $this->foo(),
            ],
        ];
    }
}
