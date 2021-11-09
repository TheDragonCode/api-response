<?php

namespace Tests\Fixtures\Laravel\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property string $bar
 */
class BarModel extends BaseModel
{
    protected function getBarAttribute(): string
    {
        return 'Bar';
    }
}
