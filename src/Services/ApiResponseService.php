<?php

namespace Helldar\ApiResponse\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

use function is_string;

class ApiResponseService
{
    /** @var array */
    protected $additionalContent = [];

    /** @var null|string|int|array|object */
    protected $content = null;

    /** @var array */
    protected $headers = [];

    /** @var int */
    protected $status_code = 200;

    /**
     * @return \Helldar\ApiResponse\Services\ApiResponseService
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
    public function status($status = 200)
    {
        $this->status_code = (int) $status;

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
     * @param array $content
     *
     * @return $this
     */
    public function additionalContent(array $content = [])
    {
        $this->additionalContent = $content;

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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function send()
    {
        return $this->response();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponse()
    {
        $content = $this->mergeContent($this->getContent());

        return JsonResponse::create($content, $this->status_code, $this->headers);
    }

    private function mergeContent($content)
    {
        if (! $this->additionalContent) {
            return $content;
        }

        $content = is_array($content) ? $content : compact('content');

        return array_merge($content, $this->additionalContent);
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
        return $this->e($this->content);
    }
}
