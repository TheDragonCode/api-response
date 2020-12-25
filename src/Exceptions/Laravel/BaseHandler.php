<?php

namespace Helldar\ApiResponse\Exceptions\Laravel;

use Helldar\Support\Facades\Arr;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

abstract class BaseHandler extends ExceptionHandler
{
    public function renderCompatible($request, Throwable $e)
    {
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
        return $this->response($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->isJson($request)
            ? $this->response($exception, 403)
            : redirect()->guest(route('login'));
    }

    protected function isJson($request, $response = null): bool
    {
        return $request->expectsJson() || $request->isJson() || $request->is('api*') || $response instanceof JsonResponse;
    }

    protected function prepareJsonResponseCompatible($request, Throwable $e)
    {
        return $this->response(
            $this->getExceptionMessage($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->withExceptionData($e),
            $this->isHttpException($e) ? $e->getHeaders() : []
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

        return ['info' => Arr::except($converted, 'message')];
    }

    protected function withExceptionData(Throwable $e): array
    {
        return array_merge($this->with(), $this->getExceptionTrace($e));
    }

    protected function response($data, int $status_code = null, array $with = [], array $headers = []): JsonResponse
    {
        $with = array_merge($this->with(), $with);

        return api_response($data, $status_code, $with, $headers);
    }

    protected function with(): array
    {
        return [];
    }
}
