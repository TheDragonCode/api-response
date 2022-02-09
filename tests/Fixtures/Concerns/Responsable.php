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

/** @mixin \Tests\Laravel\TestCase */
trait Responsable
{
    protected function response($data = null, ?int $status_code = null, array $with = []): Response
    {
        return new Response($data, $status_code, $with);
    }
}
