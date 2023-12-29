<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command\Factory;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\GetItemCommand;
use Symfony\Component\Serializer\SerializerInterface;

readonly class GetItemCommandFactory
{
    public function __construct(
        private SerializerInterface $serializer,
        private CommandHelper $commandHelper
    ) {}

    public function make(): GetItemCommand
    {
        return new GetItemCommand(
            $this->serializer,
            $this->commandHelper
        );
    }
}
