<?php

namespace Tests\Fixtures\Concerns\Laravel;

use Exception;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;

/** @mixin \Tests\Laravel\TestCase */
trait Exceptionable
{
    protected function makeDownFile(string $message = null): void
    {
        $filename = storage_path('framework/down');

        if (! file_exists($filename)) {
            file_put_contents(storage_path('framework/down'), json_encode([
                "time"    => time(),
                "message" => $message,
                "retry"   => 60,
                "allowed" => [],
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
        });
    }

    protected function getMaintenanceMiddleware(): string
    {
        switch (true) {
            case $this->isSeven():
                return CheckForMaintenanceMode::class;

            default:
                return PreventRequestsDuringMaintenance::class;
        }
    }

    protected function maintenanceModeMessage(): string
    {
        return $this->isSeven() ? 'Server Error' : 'Service Unavailable';
    }
}
