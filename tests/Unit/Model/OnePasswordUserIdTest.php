<?php

namespace Test\Unit\Model;

use Nuonic\OnePasswordCli\Model\OnePasswordUserId;
use PHPUnit\Framework\TestCase;

class OnePasswordUserIdTest extends TestCase
{

    public function testToString(): void
    {
        $id = 'r7fvoytpbo3widghmudydjqkv4' . random_bytes(4);
        $this->assertEquals($id, (string) new OnePasswordUserId($id));
    }
}
