<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli;

use Nuonic\OnePasswordCli\Command\Factory\GetAccountCommandFactory;
use Nuonic\OnePasswordCli\Command\Factory\GetItemCommandFactory;
use Nuonic\OnePasswordCli\Command\Factory\ListItemsCommandFactory;
use Nuonic\OnePasswordCli\Command\GetAccountCommand;
use Nuonic\OnePasswordCli\Command\GetItemCommand;
use Nuonic\OnePasswordCli\Command\ListItemsCommand;
use Nuonic\OnePasswordCli\Command\ReadCommand;
use Nuonic\OnePasswordCli\Command\SignInCommand;

readonly class OnePasswordCli
{
    public function __construct(
        private GetAccountCommandFactory $getAccountCommandFactory,
        private GetItemCommandFactory $getItemCommandFactory,
        private ListItemsCommandFactory $listItemsCommandFactory,
        private ReadCommand $readCommand,
        private SignInCommand $signInCommand
    ) {}

    public function getAccount(): GetAccountCommand
    {
        return $this->getAccountCommandFactory->make();
    }

    public function getItem(): GetItemCommand
    {
        return $this->getItemCommandFactory->make();
    }

    public function listItems(): ListItemsCommand
    {
        return $this->listItemsCommandFactory->make();
    }

    public function read(): ReadCommand
    {
        return $this->readCommand;
    }

    public function signIn(): SignInCommand
    {
        return $this->signInCommand;
    }
}
