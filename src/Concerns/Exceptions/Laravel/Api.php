<?php

namespace DragonCode\ApiResponse\Concerns\Exceptions\Laravel;

use Illuminate\Validation\ValidationException;

/** @mixin \DragonCode\ApiResponse\Exceptions\Laravel\BaseHandler */
trait Api
{
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        return $this->response($e);
    }
}
