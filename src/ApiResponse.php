<?php
/**
 * @author  Andrey Helldar <helldar@ai-rus.com>
 *
 * @since   2017-02-20
 * @since   2017-03-19 Remove `static`.
 */

namespace Helldar\ApiResponse;

class ApiResponse
{
    /**
     * Return response in JSON-formatted.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-02-20
     * @since  2017-03-27 Refactoring code.
     *
     * @param int        $code
     * @param mixed|null $content
     * @param int        $http_code
     *
     * @return mixed
     */
    public function get($code = 0, $content = null, $http_code = 200)
    {
        $type = $this->category($http_code) == 'error' ? 'error' : 'success';

        return $this->$type($code, $content, $http_code);
    }

    /**
     * The class definition for an error return code.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-02-20
     * @since  2017-03-27 Refactoring code.
     *
     * @param int $http_code
     *
     * @return string
     */
    private function category($http_code = 200)
    {
        $category = intval((int)$http_code / 100);

        return ($category == 4 || $category == 5) ? 'error' : 'success';
    }

    /**
     * Formation of an error response.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-02-20
     *
     * @param int  $code
     * @param null $content
     * @param int  $http_code
     *
     * @return mixed
     */
    private function error($code = 0, $content = null, $http_code = 200)
    {
        $result = [
            'error' => [
                'error_code' => $code,
                'error_msg'  => $this->getMessage($code, $content),
            ],
        ];

        return response()->json($result, $http_code);
    }

    /**
     * Get the error text.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-02-20
     *
     * @param int  $code
     * @param null $content
     *
     * @return null
     */
    private function getMessage($code = 0, $content = null)
    {
        if((int)$code == 0) {
            return $content;
        }

        return $this->trans($code);
    }

    /**
     * Translating error on key.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-02-20
     *
     * @param string $key
     *
     * @return mixed
     */
    private function trans($key = '')
    {
        return trans('api-response::api.'.$key);
    }

    /**
     * Formation of the success of the response.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     *
     * @since  2017-02-20
     * @since  2017-03-27 Refactoring code.
     *
     * @param int  $code
     * @param null $content
     * @param int  $http_code
     *
     * @return mixed
     */
    private function success($code = 0, $content = null, $http_code = 200)
    {
        return response()->json([
            'response' => $this->getMessage($code, $content),
        ], $http_code);
    }
}
