<?php

namespace DragonCode\ApiResponse\Concerns\Exceptions\Laravel;

use Illuminate\Validation\ValidationException;

/** @mixin \DragonCode\ApiResponse\Exceptions\Laravel\BaseHandler */
trait Web
{
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $this->isJson($request)
            ? $this->invalidJson($request, $e)
            : $this->invalid($request, $e);
    }
}
