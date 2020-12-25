<?php

namespace Helldar\ApiResponse\Services;

use Helldar\ApiResponse\Contracts\Parseable;
use Helldar\ApiResponse\Contracts\Resolver as ResolverContract;
use Helldar\ApiResponse\Contracts\Responsable;
use Helldar\ApiResponse\Support\Parser;
use Helldar\ApiResponse\Wrappers\Error;
use Helldar\ApiResponse\Wrappers\Resolver;
use Helldar\ApiResponse\Wrappers\Success;
use Helldar\Support\Traits\Makeable;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Response implements Responsable
{
    use Makeable;

    /** @var bool */
    public static $allow_with = true;

    /** @var bool */
    public static $wrap = true;

    /** @var mixed */
    protected $data;

    /** @var int|null */
    protected $status_code;

    /** @var array */
    protected $with = [];

    /** @var array */
    protected $headers = [];

    public static function allowWith(): void
    {
        self::$allow_with = true;
    }

    public static function withoutWith(): void
    {
        self::$allow_with = false;
    }

    public static function wrapped(): void
    {
        self::$wrap = true;
    }

    public static function withoutWrap(): void
    {
        self::$wrap = false;
    }

    public function with(array $with = []): Responsable
    {
        $this->with = $with;

        return $this;
    }

    public function headers(array $headers = []): Responsable
    {
        $this->headers = $headers;

        return $this;
    }

    public function statusCode(int $code = null): Responsable
    {
        $this->status_code = $code;

        return $this;
    }

    public function data($data = null): Responsable
    {
        $this->data = $data;

        return $this;
    }

    public function response(): JsonResponse
    {
        $wrapped = $this->getWrapped($this->getParser());

        return new JsonResponse($wrapped->get(), $wrapped->statusCode(), $this->getHeaders());
    }

    protected function getHeaders(): array
    {
        return $this->headers;
    }

    protected function getParser(): Parseable
    {
        return Parser::make()
            ->setStatusCode($this->status_code)
            ->setData($this->data)
            ->setWith($this->with)
            ->resolve();
    }

    protected function getWrapped(Parseable $parser)
    {
        $wrapper = $this->getWrapper($parser);

        return $wrapper::make()
            ->wrap(self::$wrap)
            ->allowWith(self::$allow_with)
            ->parser($parser)
            ->resolver($this->resolver());
    }

    /**
     * @param  \Helldar\ApiResponse\Contracts\Parseable  $parser
     *
     * @return \Helldar\ApiResponse\Wrappers\Wrapper
     */
    protected function getWrapper(Parseable $parser): string
    {
        return $parser->isError() ? Error::class : Success::class;
    }

    protected function resolver(): ResolverContract
    {
        return Resolver::make();
    }
}
