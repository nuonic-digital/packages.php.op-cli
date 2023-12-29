<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

use DateTimeInterface;

class OnePasswordAccount
{
    public string $id;
    public string $type;
    public string $name;
    public string $domain;
    public string $state;
    public DateTimeInterface $createdAt;
}
