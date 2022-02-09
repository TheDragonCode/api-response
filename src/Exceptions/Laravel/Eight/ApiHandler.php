<?php

/*
 * This file is part of the "dragon-code/api-response" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/api-response
 */

namespace DragonCode\ApiResponse\Exceptions\Laravel\Eight;

use DragonCode\ApiResponse\Concerns\Exceptions\Laravel\Api;
use DragonCode\ApiResponse\Exceptions\Laravel\BaseHandler;
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
        }

        if ($e instanceof Responsable) {
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
        }

        if ($e instanceof AuthenticationException) {
            return $this->response($e, 403);
        }

        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->prepareJsonResponse($request, $e);
    }
}
