<?php

namespace Helldar\ApiResponse\Contracts;

/** @mixin \Helldar\Support\Traits\Makeable */
interface Wrapper
{
    public function wrap(bool $wrap = true): self;

    public function parser(Parseable $parser): self;

    public function statusCode(): int;

    public function get();
}
