<?php

namespace Helldar\ApiResponse\Concerns\Exceptions\Laravel;

use Illuminate\Validation\ValidationException;

/** @mixin \Helldar\ApiResponse\Exceptions\Laravel\BaseHandler */
trait Api
{
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        return $this->response($e);
    }
}
