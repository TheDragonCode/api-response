<?php

namespace Helldar\ApiResponse\Wrappers;

use Helldar\ApiResponse\Contracts\Parseable;
use Helldar\ApiResponse\Contracts\Wrapper as WrapperContract;
use Helldar\Support\Facades\Arr;
use Helldar\Support\Traits\Makeable;

abstract class Wrapper implements WrapperContract
{
    use Makeable;

    /** @var bool */
    protected $wrap = true;

    /** @var \Helldar\ApiResponse\Contracts\Parseable */
    protected $parser;

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

    public function get()
    {
        $this->split();

        return $this->resolveData() ?: null;
    }

    protected function getType(): ?string
    {
        return $this->parser->getType();
    }

    protected function getData()
    {
        return $this->parser->getData() ?: null;
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
            $array = Arr::toArray($data);

            if ($this->wrap || $with || $this->isError($array)) {
                $this->setData(Arr::get($array, 'data'));
               $this->setWith(Arr::except($array, 'data'));
            } else {
                $this->setData($array);
            }

            return;
        }

        $this->setData($data);
    }

    protected function resolveData()
    {
        return $this->isError()
            ? $this->resolveError()
            : $this->resolveSuccess();
    }

    protected function resolveSuccess()
    {
        $data = $this->response();

        if ($this->wrap) {
            $data = is_array($data) && Arr::exists($data, 'data') ? $data : compact('data');
        }

        if ($this->with && ! is_array($data)) {
            $data = compact('data');
        }

        return $this->with ? array_merge($data, $this->with) : $data;
    }

    protected function resolveError()
    {
        return array_merge($this->response(), $this->with);
    }

    protected function isError($data = null): bool
    {
        if ($this->parser->isError()) {
            return true;
        }

        return is_array($data) ? isset($data['error']) : false;
    }
}
