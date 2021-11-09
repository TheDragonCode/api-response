<?php

/*
 * This file is part of the "dragon-code/api-response" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/api-response
 */

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
