<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command\Factory;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\ListItemsCommand;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ListItemsCommandFactory
{
    public function __construct(
        private SerializerInterface $serializer,
        private CommandHelper $commandHelper
    ) {}

    public function make(): ListItemsCommand
    {
        return new ListItemsCommand(
            $this->serializer,
            $this->commandHelper
        );
    }
}
