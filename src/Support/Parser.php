<?php

namespace Helldar\ApiResponse\Support;

use Exception;
use Helldar\ApiResponse\Contracts\Parseable;
use Helldar\ApiResponse\Parsers\DefaultParser;
use Helldar\ApiResponse\Parsers\Exception as ExceptionParser;
use Helldar\ApiResponse\Parsers\Laravel\Resource as LaravelResourceParser;
use Helldar\ApiResponse\Parsers\Laravel\Validation as LaravelValidationParser;
use Helldar\Support\Facades\Instance;
use Helldar\Support\Facades\Is;
use Helldar\Support\Traits\Makeable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Throwable;

final class Parser
{
    use Makeable;

    protected $success = DefaultParser::class;

    protected $error = ExceptionParser::class;

    protected $available = [
        JsonResource::class        => LaravelResourceParser::class,
        ValidationException::class => LaravelValidationParser::class,

        Exception::class => ExceptionParser::class,
        Throwable::class => ExceptionParser::class,
    ];

    protected $status_code;

    protected $data;

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setStatusCode(int $status = null): self
    {
        $this->status_code = $status;

        return $this;
    }

    public function get(): string
    {
        if ($parser = $this->find($this->classname())) {
            return $parser;
        }

        return $this->isError() ? $this->error : $this->success;
    }

    public function resolve(): Parseable
    {
        /** @var \Helldar\ApiResponse\Contracts\Parseable $parser */
        $parser = $this->get();

        return $parser::make()
            ->setStatusCode($this->status_code)
            ->setData($this->data);
    }

    protected function find(?string $classname): ?string
    {
        if (! $classname) {
            return null;
        }

        foreach ($this->available as $class => $parser) {
            if (Instance::of($classname, $class)) {
                return $parser;
            }
        }

        return null;
    }

    protected function classname(): ?string
    {
        return Is::object($this->data) ? get_class($this->data) : null;
    }

    protected function isError(): bool
    {
        return ! $this->status_code || $this->status_code >= 400 || Is::error($this->data);
    }
}
