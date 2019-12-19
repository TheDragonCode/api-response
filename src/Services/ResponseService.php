<?php

namespace Helldar\ApiResponse\Services;

use Helldar\Support\Facades\Arr;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService
{
    /** @var array */
    protected $with = [];

    /** @var null|string|int|array|object */
    protected $data = null;

    /** @var array */
    protected $headers = [];

    /** @var int */
    protected $status_code = 200;

    /**
     * @return ResponseService
     */
    public static function init()
    {
        return new self();
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function status(int $status = 200): self
    {
        $this->status_code = $status;

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function data($data = null): self
    {
        $this->data = $data instanceof Responsable
            ? $this->toResponse($data)
            : $data;

        return $this;
    }

    /**
     * @param array $with
     *
     * @return $this
     */
    public function with(array $with = []): self
    {
        $this->with = array_merge($this->with, $with);

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function headers(array $headers = []): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * @return JsonResponse
     */
    public function response(): JsonResponse
    {
        return JsonResponse::create($this->getData(), $this->status_code, $this->headers);
    }

    protected function isError(): bool
    {
        return $this->status_code >= 400;
    }

    private function e($value = null, $doubleEncode = true)
    {
        if (!is_string($value) || null === $value) {
            return $value;
        }

        return $value !== ''
            ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $doubleEncode)
            : null;
    }

    private function getData()
    {
        $this->splitData();

        $data = $this->isError()
            ? $this->getErrorData()
            : $this->getSuccessData();

        return $this->mergeData($data);
    }

    private function getErrorData(): array
    {
        return [
            'error' => [
                'code' => $this->status_code,
                'data' => $this->e($this->data),
            ],
        ];
    }

    private function getSuccessData(): array
    {
        return [
            'data' => $this->e($this->data),
        ];
    }

    private function mergeData(array $data = []): array
    {
        return $this->with
            ? array_merge($data, $this->with)
            : $data;
    }

    private function splitData(): void
    {
        if (!is_array($this->data) && !is_object($this->data)) {
            return;
        }

        $data = Arr::toArray($this->data);

        if (Arr::exists($data, 'data')) {
            $this->data(Arr::get($data, 'data'));
            $this->with(Arr::except($data, 'data'));
        }
    }

    private function toResponse(Responsable $content)
    {
        return $content
            ->toResponse(Container::getInstance()->make('request'))
            ->getData();
    }
}
