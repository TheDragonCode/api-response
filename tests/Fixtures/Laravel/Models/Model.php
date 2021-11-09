<?php

namespace Tests\Fixtures\Laravel\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property string $foo
 * @property string $bar
 */
class Model extends BaseModel
{
    protected function getFooAttribute(): string
    {
        return 'Foo';
    }

    protected function getBarAttribute(): string
    {
        return 'Bar';
    }
}
