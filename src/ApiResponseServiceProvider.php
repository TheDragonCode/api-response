<?php
/**
 * @author  Andrey Helldar <helldar@ai-rus.com>
 * @version 2017-02-20
 */

namespace Helldar\ApiResponse;

use Illuminate\Support\ServiceProvider;


class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang/en/api.php', 'api-response');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
//        $this->app['ApiResponse'] = $this->app->share(function ($app) {
//            return new ApiResponse();
//        });
    }
}