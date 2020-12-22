<?php

namespace Helldar\ApiResponse\Services;

use Exception as BaseException;
use Helldar\ApiResponse\Support\{Exception, Response as ResponseHelper};
use Helldar\Support\Facades\{Arr, Instance, Str};
use Helldar\Support\Traits\Makeable;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Response
{
    use Makeable;

    /** @var mixed */
    protected $data;

    /** @var bool */
    protected $wrap_data = true;

    /** @var int */
    protected $status_code;

    /** @var string|null */
    protected $status_type;

    /** @var array */
    protected $with = [];

    /** @var array */
    protected $headers = [];

    public function statusType(string $type = null): self
    {
        $this->status_type = $type;

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

    public function data($data = null, int $status_code = 200, bool $wrap_data = true): self
    {
        $this->wrap_data   = $wrap_data;
        $this->status_code = $status_code;

        if (Exception::isError($data)) {
            $this->status_code = Exception::getCode($data, $this->status_code);
            $this->status_type = Exception::getType($data, $this->status_type);
            $this->data        = Exception::getData($data);
        } else {
            $this->data = ResponseHelper::get($data);
        }

        return $this;
    }

    public function response(): JsonResponse
    {
        return new JsonResponse($this->getData(), $this->getStatusCode(), $this->getHeaders());
    }

    protected function splitData(): void
    {
        if (! is_array($this->data) && ! is_object($this->data)) {
            return;
        }

        $data = Arr::toArray($this->data);

        if (Arr::exists($data, 'data')) {
            $this->data(Arr::get($data, 'data'), $this->status_code);
            $this->with(Arr::except($data, 'data'));
        }
    }

    protected function getData()
    {
        $this->splitData();

        $data = $this->isError()
            ? $this->getErrorData()
            : $this->getSuccessData();

        return $this->getResolvedData($data);
    }

    protected function getErrorData()
    {
        return [
            'error' => [
                'type' => $this->getStatusType(),
                'data' => $this->e($this->data),
            ],
        ];
    }

    protected function getSuccessData()
    {
        $data = $this->e($this->data);

        if ($this->wrap_data || $this->with) {
            return isset($data['data']) ? $data : compact('data');
        }

        return $data;
    }

    protected function getResolvedData($data = [])
    {
        return is_array($data) ? array_merge($data, $this->with) : $data;
    }

    protected function getStatusCode(): int
    {
        return $this->status_code;
    }

    protected function getStatusType(): string
    {
        return Instance::basename(
            $this->status_type ?: BaseException::class
        );
    }

    protected function getHeaders(): array
    {
        return $this->headers;
    }

    protected function e($value = null, $doubleEncode = true)
    {
        if (is_null($value) || ! is_string($value)) {
            return $value;
        }

        return ! empty($value) ? Str::e($value, $doubleEncode) : null;
    }

    protected function isError(): bool
    {
        return Exception::isErrorCode($this->getStatusCode());
    }
}
