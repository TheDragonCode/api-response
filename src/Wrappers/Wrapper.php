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

namespace DragonCode\ApiResponse\Wrappers;

use DragonCode\Contracts\ApiResponse\Parseable;
use DragonCode\Contracts\ApiResponse\Resolver;
use DragonCode\Contracts\ApiResponse\Wrapper as WrapperContract;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;

abstract class Wrapper implements WrapperContract
{
    use Makeable;

    /** @var bool */
    protected $wrap = true;

    /** @var bool */
    protected $allow_with = true;

    /** @var \DragonCode\Contracts\ApiResponse\Parseable */
    protected $parser;

    /** @var \DragonCode\Contracts\ApiResponse\Resolver */
    protected $resolver;

    /** @var mixed */
    protected $data;

    /** @var array */
    protected $with = [];

    public function wrap(bool $wrap = true): WrapperContract
    {
        $this->wrap = $wrap;

        return $this;
    }

    public function parser(Parseable $parser): WrapperContract
    {
        $this->parser = $parser;

        return $this;
    }

    public function resolver(Resolver $resolver): WrapperContract
    {
        $this->resolver = $resolver;

        return $this;
    }

    public function statusCode(): int
    {
        return $this->parser->isError()
            ? ($this->parser->getStatusCode() ?: 500)
            : ($this->parser->getStatusCode() ?: 200);
    }

    public function get()
    {
        $this->split();

        return $this->resolver
            ->with($this->with, $this->allow_with)
            ->wrap($this->wrap)
            ->data($this->response())
            ->isError($this->isError())
            ->get();
    }

    public function allowWith(bool $allow = true): WrapperContract
    {
        $this->allow_with = $allow;

        return $this;
    }

    protected function getType(): ?string
    {
        return $this->parser->getType();
    }

    protected function getData()
    {
        return $this->parser->getData();
    }

    protected function setData($data = null): void
    {
        $this->data = $data;
    }

    protected function getWith(): array
    {
        return $this->parser->getWith();
    }

    protected function setWith(array $with): void
    {
        $this->with = array_merge($this->with, $with);
    }

    protected function response()
    {
        return $this->data;
    }

    protected function split(): void
    {
        $data = $this->getData();
        $with = $this->getWith();

        if (is_array($data) || is_object($data)) {
            $array = Arr::resolve($data);

            if ($this->wrap || ! empty($with) || $this->isError($array)) {
                $this->setData($this->unpackData($array));
                $this->setWith($this->unpackWith($array, $with));
            } else {
                $this->setData($array);
            }

            return;
        }

        $this->setData($data);
    }

    protected function isError($data = null): bool
    {
        if ($this->parser->isError()) {
            return true;
        }

        return is_array($data) && isset($data['error']);
    }

    protected function unpackData(array $value)
    {
        return Arr::get($value, 'data', $value);
    }

    protected function unpackWith(array $data, array $with): array
    {
        $data = isset($data['data']) ? Arr::except($data, 'data') : $with;

        return Arr::except(array_merge($data, $with), 'data');
    }
}
