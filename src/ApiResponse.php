<?php

namespace Helldar\ApiResponse;

class ApiResponse
{
    /**
     * Return response in JSON-formatted.
     *
     * @param mixed $content
     * @param int   $code
     * @param int   $http_code
     *
     * @return mixed
     */
    public function get($content = null, $code = 0, $http_code = 200)
    {
        $type = $this->category($http_code) == 'error' ? 'error' : 'success';

        return $this->$type($content, $code, $http_code);
    }

    /**
     * The class definition for an error return code.
     *
     * @param int $http_code
     *
     * @return string
     */
    private function category($http_code = 200)
    {
        $category = intval((int) $http_code / 100);

        return ($category == 4 || $category == 5) ? 'error' : 'success';
    }

    /**
     * Formation of an error response.
     *
     * @param mixed $content
     * @param int   $code
     * @param int   $http_code
     *
     * @return mixed
     */
    private function error($content = null, $code = 0, $http_code = 200)
    {
        $result = array(
            'error' => array(
                'error_code' => $code,
                'error_msg' => $this->getMessage($content, $code),
            ),
        );

        return response()->json($result, $http_code);
    }

    /**
     * Get the error text.
     *
     * @param null $content
     * @param int  $code
     *
     * @return null
     */
    private function getMessage($content = null, $code = 0)
    {
        if((int) $code !== 0) {
            return $this->trans($code);
        }

        if(is_numeric($content)) {
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
    private function trans($key = null)
    {
        return trans('api-response::api.'.$key, 'key: '.$key);
    }

    /**
     * Formation of the success of the response.
     *
     * @param mixed $content
     * @param int   $code
     * @param int   $http_code
     *
     * @return mixed
     */
    private function success($content = null, $code = 0, $http_code = 200)
    {
        return response()->json(array(
            'response' => $this->getMessage($content, $code),
        ), $http_code);
    }
}
