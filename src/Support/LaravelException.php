<?php

namespace Helldar\ApiResponse\Support;

use Helldar\Support\Facades\Instance;
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

abstract class LaravelException extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     *
     * @throws \Throwable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if ($this->isJson($request) && Instance::of($e, MaintenanceModeException::class)) {
            return $this->response($e, 503);
        }

        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if (Instance::of($e, HttpResponseException::class)) {
            return $e->getResponse();
        } elseif (Instance::of($e, AuthenticationException::class)) {
            return $this->unauthenticated($request, $e);
        } elseif (Instance::of($e, ValidationException::class)) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->isJson($request)
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->response($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->isJson($request)
            ? $this->response($exception, 401)
            : redirect()->guest(route('login'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  Symfony\Component\HttpFoundation\JsonResponse|Throwable  $response
     *
     * @return bool
     */
    protected function isJson($request, $response = null): bool
    {
        return $request->expectsJson() || $request->isJson() || $request->is('api*') || Instance::of($response, JsonResponse::class);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return api_response(
            $this->getExceptionMessage($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            array_merge($this->with(), $this->getExceptionTrace($e)),
            $this->isHttpException($e) ? $e->getHeaders() : [],
            true,
            Instance::classname($e)
        );
    }

    protected function getExceptionMessage(Throwable $e)
    {
        $converted = parent::convertExceptionToArray($e);

        return Arr::get($converted, 'message');
    }

    protected function getExceptionTrace(Throwable $e)
    {
        $converted = parent::convertExceptionToArray($e);

        return config('app.debug')
            ? ['info' => Arr::except($converted, 'message')]
            : [];
    }

    protected function with(): array
    {
        return [];
    }

    protected function response($data, int $status_code = 200): JsonResponse
    {
        return api_response($data, $status_code, $this->with());
    }
}
