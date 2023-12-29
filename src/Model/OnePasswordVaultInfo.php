<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

class OnePasswordVaultInfo
{
    public OnePasswordVaultId $id;
    public string $name;

    public function setId(string $id): OnePasswordVaultInfo
    {
        $this->id = new OnePasswordVaultId($id);
        return $this;
    }
}
