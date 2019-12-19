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
    public function status(int $status = 200)
    {
        $this->status_code = $status;

        return $this;
    }

    /**
     * @param mixed $content
     *
     * @return $this
     */
    public function content($content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param array $with
     *
     * @return $this
     */
    public function with(array $with = [])
    {
        $this->with = $with;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function headers($headers = [])
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * @return JsonResponse
     */
    public function send()
    {
        return $this->response();
    }

    /**
     * @return JsonResponse
     */
    public function response()
    {
        if ($this->isError()) {
            $this->setErrorContent();
        }

        return $this->jsonResponse();
    }

    protected function isError()
    {
        return $this->status_code >= 400;
    }

    protected function setErrorContent()
    {
        $this->content = [
            'error' => [
                'code' => $this->status_code,
                'msg'  => $this->getContent(),
            ],
        ];
    }

    /**
     * @return JsonResponse
     */
    protected function jsonResponse()
    {
        $content = $this->mergeContent($this->getContent());

        return JsonResponse::create($content, $this->status_code, $this->headers);
    }

    private function mergeContent($content)
    {
        if (! $this->with) {
            return $content;
        }

        $content = is_array($content) ? $content : compact('content');

        return array_merge($content, $this->with);
    }

    private function e($value = null, $doubleEncode = true)
    {
        if (! is_string($value) || null === $value) {
            return $value;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $doubleEncode);
    }

    private function getContent()
    {
        return $this->content instanceof Responsable
            ? $this->toResponse($this->content)
            : $this->e($this->content);
    }

    private function toResponse(Responsable $content)
    {
        $request  = Container::getInstance()->make('request');
        $response = $content->toResponse($request);

        $this->status($response->getStatusCode());

        return $response->getData();
    }
}
