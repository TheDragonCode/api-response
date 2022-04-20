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

namespace DragonCode\ApiResponse\Wrappers;

use DragonCode\Contracts\ApiResponse\Resolver as ResolverContract;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;

class Resolver implements ResolverContract
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
     * @return array|int|string|null
     */
    public function get()
    {
        return $this->is_error ? $this->failed() : $this->success();
    }

    /**
     * @return array|int|string|null
     */
    protected function success()
    {
        $data = $this->resolveData($this->data);

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
        return $this->mergeWith($this->resolveData($this->data));
    }

    protected function mergeWith(array $data): array
    {
        return $this->allow_with ? array_merge($data, $this->with) : $data;
    }

    protected function resolveData($data)
    {
        if (! is_array($data) && ! is_object($data)) {
            return $data;
        }

        return Arr::resolve($data);
    }
}
