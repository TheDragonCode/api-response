<?php

namespace Helldar\ApiResponse\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseService
{
    /**
     * @var null|string|int|array|object
     */
    protected $content = null;

    /**
     * @var int
     */
    protected $status_code = 200;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @return \Helldar\ApiResponse\Services\ApiResponseService
     */
    public static function init()
    {
        return new self;
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
     * @param null|string|int|array|object $content
     *
     * @return $this
     */
    public function content($content = null)
    {
        $this->content = $content;

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
                'msg'  => $this->content,
            ],
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponse()
    {
        return JsonResponse::create($this->content, $this->status_code, $this->headers);
    }
}
