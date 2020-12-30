<?php

namespace Helldar\ApiResponse\Contracts;

/** @mixin \Helldar\Support\Concerns\Makeable */
interface Wrapper
{
    public function wrap(bool $wrap = true): self;

    public function allowWith(bool $allow = true): self;

    public function parser(Parseable $parser): self;

    public function resolver(Resolver $resolver): self;

    public function statusCode(): int;

    public function get();
}
