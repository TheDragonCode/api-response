<?php

namespace Tests\Fixtures\Concerns;

use Exception;
use Tests\Fixtures\Entities\Response;
use Tests\Fixtures\Exceptions\FooHttpException;

/** @mixin \Tests\Laravel\TestCase */
trait Responsable
{
    protected function setRoutes($app): void
    {
        $app['router']->get('/foo', static function () {
            return api_response('ok', null, ['foo' => 'Foo']);
        })->middleware($this->getMaintenanceMiddleware());

        $app['router']->get('/bar', static function () {
            throw new Exception('Foo Bar');
        })->middleware($this->getMaintenanceMiddleware());

        $app['router']->get('/baz', static function () {
            throw new FooHttpException('Foo Http');
        })->middleware($this->getMaintenanceMiddleware());
    }

    protected function response($data = null, int $status_code = null, array $with = []): Response
    {
        return new Response($data, $status_code, $with);
    }
}
