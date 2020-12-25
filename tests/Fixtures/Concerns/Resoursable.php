<?php

namespace Tests\Fixtures\Concerns;

use Tests\Fixtures\Entities\Response;
use Tests\Fixtures\Laravel\Model;
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

    protected function successResourceResponse(): Response
    {
        return $this->response($this->successResource());
    }

    protected function createdResourceResponse(): Response
    {
        return $this->response($this->createdResource());
    }

    protected function failedResourceResponse(): Response
    {
        return $this->response($this->failedResource());
    }
}
