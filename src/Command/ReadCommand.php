<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command;

use Nuonic\OnePasswordCli\Command\Exception\CommandFailedException;
use Nuonic\OnePasswordCli\Model\OnePasswordItemRef;
use Symfony\Component\Process\Process;

class ReadCommand
{
    /**
     * @param OnePasswordItemRef $itemRef
     * @return string
     * @throws CommandFailedException
     */
    public function execute(OnePasswordItemRef $itemRef): string
    {
        $command = [
            'op', 'read', '--no-newline', (string) $itemRef
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CommandFailedException($process);
        }

        return $process->getOutput();
    }
}
