<?php

namespace Tests\Fixtures\Laravel;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property string $foo
 * @property string $bar
 */
final class Model extends BaseModel
{
    protected function getFooAttribute($value): string
    {
        return 'Foo';
    }

    protected function getBarAttribute(): string
    {
        return 'Bar';
    }
}
