<?php

namespace Helldar\ApiResponse;

class ApiResponse
{
    /**
     * @var array|string
     */
    protected $result;

    /**
     * Return response in JSON-formatted.
     *
     * @param mixed $content
     * @param int   $http_code
     *
     * @return mixed
     */
    public function get($content = null, $http_code = 200)
    {
        if ($this->isErrorCategory($http_code)) {
            $this->error($content, $http_code);
        } else {
            $this->success($content, $http_code);
        }

        return response()->json($this->result, $http_code);
    }

    /**
     * The class definition for an error return code.
     *
     * @param int $http_code
     *
     * @return bool
     */
    protected function isErrorCategory($http_code = 200)
    {
        $category = intval((int) $http_code / 100);

        return $category == 4 || $category == 5;
    }

    /**
     * Formation of an error response.
     *
     * @param mixed $content
     * @param int   $http_code
     */
    protected function error($content = null, $http_code = 400)
    {
        $this->result = array(
            'error' => array(
                'error_code' => is_numeric($content) ? $content : $http_code,
                'error_msg' => $this->getMessage($content),
            ),
        );
    }

    /**
     * Get the error text.
     *
     * @param null $content
     *
     * @return null
     */
    protected function getMessage($content = null)
    {
        if (is_numeric($content)) {
            return $this->trans((int) $content);
        }

        return $content;
    }

    /**
     * Translating error on key.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function trans($key = null)
    {
        return trans('api-response::api.'.$key);
    }

    /**
     * Formation of the success of the response.
     *
     * @param mixed $content
     * @param int   $http_code
     */
    protected function success($content = null, $http_code = 400)
    {
        $this->result = array(
            'response' => $this->getMessage($content),
        );
    }
}
