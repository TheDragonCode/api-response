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
