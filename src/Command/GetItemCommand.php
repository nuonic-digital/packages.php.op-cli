<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command;

use Nuonic\OnePasswordCli\Collection\OnePasswordFieldCollection;
use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\Exception\CommandFailedException;
use Nuonic\OnePasswordCli\Model\OnePasswordItem;
use Nuonic\OnePasswordCli\Model\OnePasswordItemId;
use Nuonic\OnePasswordCli\Model\OnePasswordVaultId;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\SerializerInterface;

class GetItemCommand
{
    /**
     * @var array<string, string|bool>
     */
    private array $options = [
        '--format' => 'json'
    ];

    /**
     * @param SerializerInterface $serializer
     * @param CommandHelper $commandHelper
     *
     * @internal use GetItemCommandCommandFactory for instantiation as this object holds state!
     */
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly CommandHelper $commandHelper
    ) {}

    public function filterFields(string ...$fields): GetItemCommand
    {
        $this->options['--fields'] = implode(',', $fields);
        return $this;
    }

    public function includeArchive(): GetItemCommand
    {
        $this->options['--include-archive'] = true;
        return $this;
    }

    public function filterVault(string|OnePasswordVaultId $vault): GetItemCommand
    {
        $this->options['--vault'] = (string) $vault;
        return $this;
    }

    /**
     * @param OnePasswordItemId|string $itemIdOrName
     * @return OnePasswordItem|OnePasswordFieldCollection
     * @throws CommandFailedException
     */
    public function execute(OnePasswordItemId|string $itemIdOrName): OnePasswordItem|OnePasswordFieldCollection
    {
        $command = [
            'op', 'item', 'get', (string) $itemIdOrName,
            ...$this->commandHelper->processOptionsToCommandArray($this->options)
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CommandFailedException($process);
        }

        return $this->serializer->deserialize(
            $process->getOutput(),
            in_array('--fields', $command, true) ? OnePasswordFieldCollection::class : OnePasswordItem::class,
            'json'
        );
    }
}
