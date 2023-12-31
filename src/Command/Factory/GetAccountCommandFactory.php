<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command\Factory;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\GetAccountCommand;
use Symfony\Component\Serializer\SerializerInterface;

readonly class GetAccountCommandFactory
{
    public function __construct(
        private SerializerInterface $serializer,
        private CommandHelper $commandHelper
    ) {}

    public function make(): GetAccountCommand
    {
        return new GetAccountCommand(
            $this->serializer,
            $this->commandHelper
        );
    }
}
