<?php

namespace Helldar\ApiResponse\Wrappers;

use Helldar\ApiResponse\Contracts\Parseable;
use Helldar\ApiResponse\Contracts\Wrapper as WrapperContract;
use Helldar\Support\Facades\Arr;
use Helldar\Support\Traits\Makeable;

abstract class Wrapper implements WrapperContract
{
    use Makeable;

    protected $wrap = true;

    /** @var \Helldar\ApiResponse\Contracts\Parseable */
    protected $parser;

    protected $with = [];

    protected $data;

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

    public function with(array $data = []): WrapperContract
    {
        $this->with = array_merge($this->with, $data);

        return $this;
    }

    public function withWhen(bool $when, array $data = []): WrapperContract
    {
        if ($when) {
            $this->with($data);
        }

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
        $this->data = $data ?: null;
    }

    protected function getWith(): array
    {
        return array_merge($this->with, $this->parser->getWith());
    }

    protected function response()
    {
        return $this->data;
    }

    protected function split(): void
    {
        $data = $this->getData();

        $this->with($this->getWith());

        if (is_array($data) || is_object($data)) {
            $array = Arr::toArray($data);

            if ($this->wrap || $this->with || $this->isError($array)) {
                $this->setData(Arr::get($array, 'data'));
                $this->with(Arr::except($array, 'data'));
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

        if ($this->wrap || $this->with) {
            $data = is_array($data) && Arr::exists($data, 'data') ? $data : compact('data');
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
