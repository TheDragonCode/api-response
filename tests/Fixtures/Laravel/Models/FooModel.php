<?php

namespace Tests\Fixtures\Laravel\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $foo
 * @property-read BarModel $bar
 */
final class FooModel extends BaseModel
{
    public function bar(): HasOne
    {
        return $this->hasOne(BarModel::class);
    }

    protected function getFooAttribute(): string
    {
        return 'Foo';
    }
}
