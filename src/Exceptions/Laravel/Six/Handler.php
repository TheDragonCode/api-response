<?php

namespace Helldar\ApiResponse\Exceptions\Laravel\Six;

use Exception;
use Helldar\ApiResponse\Exceptions\Laravel\BaseHandler;

abstract class Handler extends BaseHandler
{
    public function render($request, Exception $e)
    {
        return $this->renderCompatible($request, $e);
    }

    protected function prepareJsonResponse($request, Exception $e)
    {
        return $this->prepareJsonResponseCompatible($request, $e);
    }
}
