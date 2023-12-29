<?php

namespace Test\Integration\Command;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\GetAccountCommand;
use Nuonic\OnePasswordCli\Serializer\CollectionDenormalizer;
use Nuonic\OnePasswordCli\Serializer\ModelDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class GetAccountCommandTest extends TestCase
{
    private GetAccountCommand $command;

    protected function setUp(): void
    {
        $serializer = new Serializer(
            [new DateTimeNormalizer(), new CollectionDenormalizer(), new ModelDenormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
        $commandHelper = new CommandHelper();
        $this->command = new GetAccountCommand(
            $serializer,
            $commandHelper
        );
    }

    public function testExecute(): void
    {
        $result = $this->command->execute();
        $this->assertEquals('nuonic', $result->domain);
    }
}
