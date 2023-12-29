<?php

namespace Test\Model;

use Nuonic\OnePasswordCli\Model\OnePasswordVaultId;
use PHPUnit\Framework\TestCase;

class OnePasswordVaultIdTest extends TestCase
{

    public function testToString(): void
    {
        $id = 'r7fvoytpbo3widghmudydjqkv4' . random_bytes(4);
        $this->assertEquals($id, (string) new OnePasswordVaultId($id));
    }
}
