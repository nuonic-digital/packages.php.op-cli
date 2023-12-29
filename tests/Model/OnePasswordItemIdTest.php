<?php

namespace Test\Model;

use Nuonic\OnePasswordCli\Model\OnePasswordItemId;
use PHPUnit\Framework\TestCase;

class OnePasswordItemIdTest extends TestCase
{

    public function testToString(): void
    {
        $id = 'r7fvoytpbo3widghmudydjqkv4' . random_bytes(4);
        $this->assertEquals($id, (string) new OnePasswordItemId($id));
    }
}
