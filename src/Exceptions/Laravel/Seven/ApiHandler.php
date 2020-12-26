<?php

namespace Helldar\ApiResponse\Exceptions\Laravel\Seven;

use Helldar\ApiResponse\Concerns\Exceptions\Laravel\Api;
use Helldar\ApiResponse\Exceptions\Laravel\BaseHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Throwable;

abstract class ApiHandler extends BaseHandler
{
    use Api;

    public function render($request, Throwable $e)
    {
        if ($e instanceof MaintenanceModeException) {
            return $this->response($e);
        }

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return $this->response(
                Router::toResponse($request, $response)
            );
        } elseif ($e instanceof Responsable) {
            return $this->response($e->toResponse($request));
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $this->response($e);
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->prepareJsonResponse($request, $e);
    }
}
