<?php

namespace Helldar\ApiResponse\Wrappers;

use Helldar\ApiResponse\Contracts\Resolver as ResolverContract;
use Helldar\Support\Facades\Arr;
use Helldar\Support\Traits\Makeable;

final class Resolver implements ResolverContract
{
    use Makeable;

    protected $with = [];

    protected $data;

    protected $is_error = false;

    protected $allow_with = true;

    protected $wrap = true;

    public function with(array $with, bool $allow = true): ResolverContract
    {
        $this->with       = $with;
        $this->allow_with = $allow;

        return $this;
    }

    public function wrap(bool $allow = true): ResolverContract
    {
        $this->wrap = $allow;

        return $this;
    }

    public function data($data): ResolverContract
    {
        $this->data = $data;

        return $this;
    }

    public function isError(bool $is_error = false): ResolverContract
    {
        $this->is_error = $is_error;

        return $this;
    }

    /**
     * @return array|string|int|null
     */
    public function get()
    {
        return $this->is_error ? $this->failed() : $this->success();
    }

    /**
     * @return array|string|int|null
     */
    protected function success()
    {
        $data = $this->data;

        if ($this->wrap) {
            $data = is_array($data) && Arr::exists($data, 'data') ? $data : compact('data');
        }

        if (! empty($this->with) && ! is_array($data)) {
            $data = compact('data');
        }

        return ! empty($this->with) ? $this->mergeWith($data) : $data;
    }

    protected function failed(): array
    {
        return $this->mergeWith($this->data);
    }

    protected function mergeWith(array $data): array
    {
        return $this->allow_with ? array_merge($data, $this->with) : $data;
    }
}
