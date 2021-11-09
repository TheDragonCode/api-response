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

namespace Tests\Fixtures\Concerns;

use Tests\Fixtures\Entities\Response;
use Tests\Fixtures\Laravel\Models\Model;
use Tests\Fixtures\Laravel\Resources\Created;
use Tests\Fixtures\Laravel\Resources\Failed;
use Tests\Fixtures\Laravel\Resources\Success;

/** @mixin \Tests\Fixtures\Concerns\Responsable */
trait Resoursable
{
    protected function laravelModel(): Model
    {
        return new Model();
    }

    protected function successResource(): Success
    {
        return Success::make($this->laravelModel());
    }

    protected function createdResource(): Created
    {
        return Created::make($this->laravelModel());
    }

    protected function failedResource(): Failed
    {
        return Failed::make($this->laravelModel());
    }

    protected function successResourceResponse(int $status_code = null): Response
    {
        return $this->response($this->successResource(), $status_code);
    }

    protected function createdResourceResponse(int $status_code = null): Response
    {
        return $this->response($this->createdResource(), $status_code);
    }

    protected function failedResourceResponse(int $status_code = null): Response
    {
        return $this->response($this->failedResource(), $status_code);
    }
}
