<?php

namespace Helldar\ApiResponse\Support;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

use function __;
use function api_response;
use function config;
use function method_exists;
use function redirect;

abstract class LaravelException extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     *
     * @throws \Throwable
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function render($request, Throwable $e)
    {
        if ($this->isJson($request) && $e instanceof MaintenanceModeException) {
            return api_response(__('Maintenance Mode'), 503);
        }

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->isJson($request)
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return api_response($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->isJson($request)
            ? api_response($exception)
            : redirect()->guest(route('login'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable|Symfony\Component\HttpFoundation\JsonResponse  $response
     *
     * @return bool
     */
    protected function isJson($request, $response = null): bool
    {
        return $request->expectsJson() || $request->isJson() || $request->is('api*') || $response instanceof JsonResponse;
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return api_response(
            $this->convertExceptionToArray($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            [],
            $this->isHttpException($e) ? $e->getHeaders() : []
        );
    }

    protected function convertExceptionToArray(Throwable $e)
    {
        $converted = parent::convertExceptionToArray($e);

        return config('app.debug')
            ? $converted
            : Arr::get($converted, 'message');
    }
}
