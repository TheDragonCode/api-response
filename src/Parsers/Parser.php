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

use DragonCode\ApiResponse\Concerns\Errors;
use DragonCode\ApiResponse\Services\Response;
use DragonCode\Contracts\ApiResponse\Parseable;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Instance;
use DragonCode\Support\Facades\Helpers\Is;
use Exception as BaseException;

abstract class Parser implements Parseable
{
    use Makeable;
    use Errors;

    /** @var mixed */
    protected $data;

    /** @var array */
    protected $with = [];

    /** @var int|null */
    protected $status_code;

    public function setData($data): Parseable
    {
        $this->data = $data;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->isError(true)
            ? ($this->status_code ?: 400)
            : ($this->status_code ?: 200);
    }

    public function setStatusCode(?int $code = null): Parseable
    {
        $this->status_code = $code;

        return $this;
    }

    public function getType(): ?string
    {
        if ($this->isError()) {
            return Is::error($this->data) ? Instance::basename($this->data) : BaseException::class;
        }

        return null;
    }

    public function getWith(): array
    {
        return $this->with;
    }

    public function setWith(array $with = []): Parseable
    {
        if ($this->allowWith()) {
            $this->with = array_merge($this->with, $with);
        }

        return $this;
    }

    protected function allowWith(): bool
    {
        return Response::$allow_with;
    }
}
