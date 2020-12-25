<?php

namespace Helldar\ApiResponse\Contracts;

interface Resolver
{
    public function with(array $with, bool $allow = true): self;

    public function wrap(bool $allow = true): self;

    public function data($data): self;

    public function isError(bool $is_error = false): self;

    public function get();
}
