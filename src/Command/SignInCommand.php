<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\Exception\CommandFailedException;
use Symfony\Component\Process\Process;

class SignInCommand
{
    /**
     * @var array<string, string|bool>
     */
    private array $options = [];

    public function __construct(
        private readonly CommandHelper $commandHelper
    ) {}

    public function selectAccount(string $account): SignInCommand
    {
        $this->options['--account'] = $account;
        return $this;
    }

    /**
     * @throws CommandFailedException
     */
    public function execute(): void
    {
        $command = [
            'op', 'signin',
            ...$this->commandHelper->processOptionsToCommandArray($this->options)
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CommandFailedException($process);
        }
    }
}
