<?php

namespace Helldar\ApiResponse\Contracts;

use Symfony\Component\HttpFoundation\JsonResponse;

interface Responsable
{
    public static function allowWith(): void;

    public static function withoutWith(): void;

    public function wrapper(bool $wrap = true): self;

    public function with(array $with = []): self;

    public function headers(array $headers = []): self;

    public function statusCode(int $code = null): self;

    public function data($data = null): self;

    public function response(): JsonResponse;
}
