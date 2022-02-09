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

namespace DragonCode\ApiResponse\Support;

use DragonCode\ApiResponse\Concerns\Errors;
use DragonCode\ApiResponse\Parsers\Exception as ExceptionParser;
use DragonCode\ApiResponse\Parsers\Laravel\Resource as LaravelResourceParser;
use DragonCode\ApiResponse\Parsers\Laravel\Validation as LaravelValidationParser;
use DragonCode\ApiResponse\Parsers\Main;
use DragonCode\Contracts\ApiResponse\Parseable;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Instance;
use DragonCode\Support\Facades\Helpers\Is;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Throwable;

class Parser
{
    use Makeable;
    use Errors;

    /** @var string */
    protected $success = Main::class;

    /** @var string */
    protected $error = ExceptionParser::class;

    /** @var string[] */
    protected $available = [
        JsonResource::class        => LaravelResourceParser::class,
        ValidationException::class => LaravelValidationParser::class,

        Exception::class => ExceptionParser::class,
        Throwable::class => ExceptionParser::class,
    ];

    /** @var int|null */
    protected $status_code;

    /** @var mixed */
    protected $data;

    /** @var array */
    protected $with = [];

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setWith(array $with = []): self
    {
        $this->with = $with;

        return $this;
    }

    public function setStatusCode(?int $status = null): self
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
        /** @var \DragonCode\Contracts\ApiResponse\Parseable $parser */
        $parser = $this->get();

        return $parser::make()
            ->setStatusCode($this->status_code)
            ->setData($this->data)
            ->setWith($this->with);
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
        return Is::object($this->data) ? Instance::classname($this->data) : null;
    }
}
