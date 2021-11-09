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

namespace DragonCode\ApiResponse\Parsers\Laravel;

use DragonCode\ApiResponse\Parsers\Parser;

/** @property \Illuminate\Validation\ValidationException $data */
class Validation extends Parser
{
    public function getData()
    {
        return ['data' => $this->data->errors()];
    }

    public function getStatusCode(): int
    {
        return $this->status_code ?: ($this->data->status ?? parent::getStatusCode());
    }
}
