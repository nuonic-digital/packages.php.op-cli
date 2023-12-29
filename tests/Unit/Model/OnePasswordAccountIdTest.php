<?php

namespace Test\Unit\Model;

use Nuonic\OnePasswordCli\Model\OnePasswordAccountId;
use PHPUnit\Framework\TestCase;

class OnePasswordAccountIdTest extends TestCase
{

    public function testToString(): void
    {
        $id = 'r7fvoytpbo3widghmudydjqkv4' . random_bytes(4);
        $this->assertEquals($id, (string) new OnePasswordAccountId($id));
    }
}
