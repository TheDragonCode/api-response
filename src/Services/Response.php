<?php

namespace Helldar\ApiResponse\Services;

use Helldar\ApiResponse\Contracts\Parseable;
use Helldar\ApiResponse\Support\Parser;
use Helldar\ApiResponse\Wrappers\Error;
use Helldar\ApiResponse\Wrappers\Success;
use Helldar\Support\Traits\Makeable;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Response
{
    use Makeable;

    /** @var mixed */
    protected $data;

    /** @var bool */
    protected $wrap = true;

    /** @var int|null */
    protected $status_code;

    /** @var array */
    protected $with = [];

    /** @var array */
    protected $headers = [];

    public function wrapper(bool $wrap = true): self
    {
        $this->wrap = $wrap;

        return $this;
    }

    public function with(array $with = []): self
    {
        $this->with = array_merge($this->with, $with);

        return $this;
    }

    public function headers(array $headers = []): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function data($data = null, int $status_code = null): self
    {
        $this->data        = $data;
        $this->status_code = $status_code;

        return $this;
    }

    public function response(): JsonResponse
    {
        $parser = $this->getParser();

        return new JsonResponse($this->getData($parser), $parser->getStatusCode(), $this->getHeaders());
    }

    protected function getData(Parseable $parser)
    {
        if ($data = $this->getWrapper($parser)) {
            return $data;
        }

        return [];
    }

    protected function getHeaders(): array
    {
        return $this->headers;
    }

    protected function getParser(): Parseable
    {
        return Parser::make()
            ->setData($this->data)
            ->setStatusCode($this->status_code)
            ->resolve();
    }

    protected function getWrapper(Parseable $parser)
    {
        /** @var \Helldar\ApiResponse\Wrappers\Wrapper $wrapper */
        $wrapper = $parser->isError() ? Error::class : Success::class;

        return $wrapper::make()
            ->parser($parser)
            ->wrap($this->wrap)
            ->with($this->with)
            ->get();
    }
}
