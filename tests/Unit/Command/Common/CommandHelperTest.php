<?php

namespace Test\Unit\Command\Common;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use PHPUnit\Framework\TestCase;

class CommandHelperTest extends TestCase
{

    public function testProcessOptionsToCommandArray(): void
    {
        $helper = new CommandHelper();
        $this->assertEquals([
            '-a', 1,
            '--test',
            '--user', 'a'
        ], $helper->processOptionsToCommandArray([
            '-a' => 1,
            '--test' => true,
            '--blue' => false,
            '--user' => "a"
        ]));
    }
}
