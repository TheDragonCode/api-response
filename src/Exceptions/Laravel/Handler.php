<?php

namespace Helldar\ApiResponse\Exceptions\Laravel;

use Throwable;

abstract class Handler extends BaseHandler
{
    public function render($request, Throwable $e)
    {
        return $this->renderCompatible($request, $e);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return $this->prepareJsonResponseCompatible($request, $e);
    }
}
