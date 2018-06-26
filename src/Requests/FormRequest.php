<?php

namespace Helldar\ApiResponse\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class FormRequest extends LaravelFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors   = $validator->errors()->all();
        $response = api_response($errors, 400);
        
        throw new HttpResponseException($response);
    }
}
