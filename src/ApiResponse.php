<?php


namespace Helldar\ApiResponse;

use Illuminate\Support\Facades\App;

class ApiResponse
{
    private static $trans = [];

    /**
     * Return response in JSON-formatted.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     * @param int        $code
     * @param mixed|null $content
     * @param int        $http_code
     *
     * @return mixed
     */
    public static function response($code = 0, $content = null, $http_code = 200)
    {
        static::loadingLocalization();

        if (static::category($http_code) == 'error') {
            return static::error($code, $content, $http_code);
        }

        return static::success($code, $content, $http_code);
    }

    /**
     * Loading localization from file.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     */
    private static function loadingLocalization()
    {
        if (sizeof(static::$trans)) {
            return;
        }

        $path     = __DIR__ . '/lang/%s/api.php';
        $filename = sprintf($path, App::getLocale());

        if (!file_exists($filename)) {
            $filename = sprintf($path, 'en');
        }

        static::$trans = include_once $filename;
    }

    /**
     * The class definition for an error return code.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     * @param int $http_code
     *
     * @return string
     */
    private static function category($http_code = 200)
    {
        $category = intval((int)$http_code / 100);

        if ($category == 4 || $category == 5) {
            return 'error';
        }

        return 'success';
    }

    /**
     * Formation of an error response.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     * @param int  $code
     * @param null $content
     * @param int  $http_code
     *
     * @return mixed
     */
    private static function error($code = 0, $content = null, $http_code = 200)
    {
        $result = [
            'error' => [
                'error_code' => $code,
                'error_msg'  => static::getMessage($code, $content),
            ],
        ];

        return response()->json($result, $http_code);
    }

    /**
     * Get the error text.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     * @param int  $code
     * @param null $content
     *
     * @return null
     */
    private static function getMessage($code = 0, $content = null)
    {
        if ((int)$code == 0) {
            return $content;
        }

        return static::trans($code);
    }

    /**
     * Translating error on key.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     * @param string $key
     *
     * @return mixed
     */
    private static function trans($key = '')
    {
        try {
            if (array_key_exists((string)$key, static::$trans)) {
                return static::$trans[$key];
            }

            return $key;
        } catch (\Exception $e) {
            return $key;
        }
    }

    /**
     * Formation of the success of the response.
     *
     * @author Andrey Helldar <helldar@ai-rus.com>
     * @since  2017-02-20
     *
     * @param int  $code
     * @param null $content
     * @param int  $http_code
     *
     * @return mixed
     */
    private static function success($code = 0, $content = null, $http_code = 200)
    {
        $result = [
            'response' => static::getMessage($code, $content),
        ];

        return response()->json($result, $http_code);
    }
}