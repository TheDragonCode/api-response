<?php

namespace Helldar\ApiResponse\Exceptions\Laravel;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Throwable;

abstract class ApiHandler extends BaseHandler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof PreventRequestsDuringMaintenance) {
            return $this->response($e);
        }

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return $this->response($response);
        } elseif ($e instanceof Responsable) {
            return $this->response($e);
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

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return $this->prepareJsonResponseCompatible($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->response($exception, 403);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        return $this->response($e);
    }
}
