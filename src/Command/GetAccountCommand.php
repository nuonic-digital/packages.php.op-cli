<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\Exception\CommandFailedException;
use Nuonic\OnePasswordCli\Model\OnePasswordAccount;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\SerializerInterface;

class GetAccountCommand
{
    /**
     * @var array<string, string|bool>
     */
    private array $options = [
        '--format' => 'json'
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CommandHelper $commandHelper
    ) {}

    /**
     * @return OnePasswordAccount
     * @throws CommandFailedException
     */
    public function execute(): OnePasswordAccount
    {
        $command = [
            'op', 'account', 'get',
            ...$this->commandHelper->processOptionsToCommandArray($this->options)
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CommandFailedException($process);
        }

        return $this->serializer->deserialize(
            $process->getOutput(),
            OnePasswordAccount::class,
            'json'
        );
    }
}
