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

namespace DragonCode\ApiResponse\Parsers;

use DragonCode\Support\Facades\Instances\Call;
use DragonCode\Support\Facades\Instances\Instance;
use Exception as BaseException;
use Throwable;

/**
 * @property \Exception|Throwable $data
 */
class Exception extends Parser
{
    protected $is_error = true;

    public function getData()
    {
        if ($data = $this->getThrowableContent()) {
            return $data;
        }

        return $this->data;
    }

    public function getStatusCode(): int
    {
        if ($this->isErrorCode($this->status_code)) {
            return $this->status_code;
        }

        return Call::runMethods($this->data, ['getStatusCode', 'getCode']) ?: 400;
    }

    /**
     * @return array|int|string|null
     */
    protected function getThrowableContent()
    {
        return Instance::of($this->data, [BaseException::class, Throwable::class])
            ? Call::runMethods($this->data, ['getOriginalContent', 'getContent', 'getResponse', 'getMessage'])
            : null;
    }
}
