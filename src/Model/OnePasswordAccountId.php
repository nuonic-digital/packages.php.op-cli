<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

readonly class OnePasswordAccountId
{
    public function __construct(
        private string $id
    ) {}

    public function __toString(): string
    {
        return $this->id;
    }
}
