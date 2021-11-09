<?php

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
