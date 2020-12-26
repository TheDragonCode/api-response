<?php

namespace Helldar\ApiResponse\Exceptions\Laravel\Eight;

use Helldar\ApiResponse\Concerns\Exceptions\Laravel\Api;
use Helldar\ApiResponse\Exceptions\Laravel\BaseHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use Throwable;

abstract class ApiHandler extends BaseHandler
{
    use Api;

    public function render($request, Throwable $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return $this->response(
                Router::toResponse($request, $response)
            );
        } elseif ($e instanceof Responsable) {
            return $this->response($e->toResponse($request));
        }

        $e = $this->prepareException($this->mapException($e));

        foreach ($this->renderCallbacks as $renderCallback) {
            if (is_a($e, $this->firstClosureParameterType($renderCallback))) {
                $response = $renderCallback($e, $request);

                if (! is_null($response)) {
                    return $this->response($response);
                }
            }
        }

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
