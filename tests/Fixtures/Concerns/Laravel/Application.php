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

namespace Tests\Fixtures\Concerns\Laravel;

use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Foundation\Application as LaravelApp;

trait Application
{
    public function isSeven(): bool
    {
        return $this->is('7.');
    }

    public function isEight(): bool
    {
        return $this->is('8.');
    }

    public function is(string $version): bool
    {
        return Str::startsWith($this->version(), $version);
    }

    public function version(): string
    {
        return LaravelApp::VERSION;
    }
}
