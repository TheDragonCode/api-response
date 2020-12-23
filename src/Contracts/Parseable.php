<?php

namespace Helldar\ApiResponse\Contracts;

/** @mixin \Helldar\Support\Traits\Makeable */
interface Parseable
{
    public function setData($data): self;

    public function setStatusCode(int $code = null): self;

    public function getStatusCode(): int;

    public function getData();

    public function getWith(): array;

    public function getType(): ?string;

    public function isError(): bool;
}
