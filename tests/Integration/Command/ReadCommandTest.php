<?php

namespace Test\Integration\Command;

use Nuonic\OnePasswordCli\Command\ReadCommand;
use Nuonic\OnePasswordCli\Model\OnePasswordItemRef;
use PHPUnit\Framework\TestCase;

class ReadCommandTest extends TestCase
{

    public function testExecute(): void
    {
        $command = new ReadCommand();

        $passwordResult = $command->execute(new OnePasswordItemRef("op://packages.php.op-cli-integration-1/password/password"));
        $this->assertEquals('fBe!Cb2zBM_zV8j9k-o-VKhu.y', $passwordResult);

        $userResult = $command->execute(new OnePasswordItemRef("op://packages.php.op-cli-integration-1/password/username"));
        $this->assertEquals('user', $userResult);
    }
}
