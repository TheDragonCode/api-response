<?php

namespace Helldar\ApiResponse\Services;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService
{
    /** @var array */
    protected $with = [];

    /** @var null|string|int|array|object */
    protected $content = null;

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
     * @param mixed $content
     *
     * @return $this
     */
    public function content($content = null): self
    {
        $this->content = $content instanceof Responsable
            ? $this->toResponse($content)
            : $content;

        return $this;
    }

    /**
     * @param array $with
     *
     * @return $this
     */
    public function with(array $with = []): self
    {
        $this->with = $with;

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
        return JsonResponse::create($this->getContent(), $this->status_code, $this->headers);
    }

    protected function isError(): bool
    {
        return $this->status_code >= 400;
    }

    private function e($value = null, $doubleEncode = true)
    {
        if (! is_string($value) || null === $value) {
            return $value;
        }

        return $value !== ''
            ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $doubleEncode)
            : null;
    }

    private function getContent()
    {
        $content = $this->isError()
            ? $this->getErrorContent()
            : $this->getSuccessContent();

        return $this->mergeWith($content);
    }

    private function getErrorContent(): array
    {
        return [
            'error' => [
                'code' => $this->status_code,
                'data' => $this->e($this->content),
            ],
        ];
    }

    private function getSuccessContent()
    {
        return [
            'data' => $this->e($this->content),
        ];
    }

    private function mergeWith(array $content = []): array
    {
        return $this->with
            ? array_merge($content, $this->with)
            : $content;
    }

    private function toResponse(Responsable $content)
    {
        return $content
            ->toResponse(Container::getInstance()->make('request'))
            ->getData();
    }
}
