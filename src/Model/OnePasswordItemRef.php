<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

use Nuonic\OnePasswordCli\Model\Exception\MalformedItemRefException;

readonly class OnePasswordItemRef
{
    public function __construct(
        private string $ref
    ) {
        if (!str_starts_with($this->ref, 'op://')) {
            throw new MalformedItemRefException($this->ref);
        }
    }

    public function __toString(): string
    {
        return $this->ref;
    }
}
