<?php

namespace Tests\Fixtures\Concerns\Laravel;

use Exception;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;

/** @mixin \Tests\Laravel\TestCase */
trait Exceptionable
{
    protected function makeDownFile(): void
    {
        $filename = storage_path('framework/down');

        if (! file_exists($filename)) {
            file_put_contents(storage_path('framework/down'), json_encode([
                'time'    => time(),
                'message' => 'Service Unavailable',
                'retry'   => 60,
                'allowed' => [],
            ]));
        }
    }

    protected function removeDownFile(): void
    {
        @unlink(storage_path('framework/down'));
    }

    protected function setRoutes($app): void
    {
        $app['router']->get('/foo', static function () {
            return api_response('ok');
        })->middleware($this->getMaintenanceMiddleware());

        $app['router']->get('/bar', static function () {
            throw new Exception('Foo Bar');
        })->middleware($this->getMaintenanceMiddleware());
    }

    protected function getMaintenanceMiddleware(): string
    {
        return $this->isSeven()
            ? CheckForMaintenanceMode::class
            : PreventRequestsDuringMaintenance::class;
    }

    protected function getMaintenanceType(): string
    {
        return $this->isSeven() ? 'MaintenanceModeException' : 'HttpException';
    }
}
