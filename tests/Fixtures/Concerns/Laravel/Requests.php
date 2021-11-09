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

namespace Tests\Fixtures\Concerns\Laravel;

use Tests\Fixtures\Entities\Response;

/** @mixin \Tests\Laravel\TestCase */
trait Requests
{
    protected function requestFoo(): Response
    {
        return $this->request('/foo');
    }

    protected function requestBar(): Response
    {
        return $this->request('/bar');
    }

    protected function request(string $uri): Response
    {
        return $this->response(
            $this->get($uri)
        );
    }
}
