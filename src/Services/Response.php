<?php

namespace DragonCode\ApiResponse\Services;

use DragonCode\ApiResponse\Support\Parser;
use DragonCode\ApiResponse\Wrappers\Error;
use DragonCode\ApiResponse\Wrappers\Resolver;
use DragonCode\ApiResponse\Wrappers\Success;
use DragonCode\Contracts\ApiResponse\Parseable;
use DragonCode\Contracts\ApiResponse\Resolver as ResolverContract;
use DragonCode\Contracts\ApiResponse\Responsable;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class Response implements Responsable
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

        if (class_exists(JsonResource::class)) {
            JsonResource::wrap('data');
        }
    }

    public static function withoutWrap(): void
    {
        self::$wrap = false;

        if (class_exists(JsonResource::class)) {
            JsonResource::withoutWrapping();
        }
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
     * @param  \DragonCode\Contracts\ApiResponse\Parseable  $parser
     *
     * @return \DragonCode\ApiResponse\Wrappers\Wrapper|string
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
