<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command;

use Nuonic\OnePasswordCli\Collection\OnePasswordListingItemCollection;
use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\Exception\CommandFailedException;
use Nuonic\OnePasswordCli\Model\OnePasswordListingItem;
use Nuonic\OnePasswordCli\Model\OnePasswordVaultId;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\SerializerInterface;

class ListItemsCommand
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

    public function filterCategories(string ...$categories): ListItemsCommand
    {
        $this->options['--categories'] = implode(',', $categories);
        return $this;
    }

    public function filterTags(string ...$tags): ListItemsCommand
    {
        $this->options['--tags'] = implode(',', $tags);
        return $this;
    }

    public function onlyFavorites(): ListItemsCommand
    {
        $this->options['--favorite'] = true;
        return $this;
    }

    public function includeArchive(): ListItemsCommand
    {
        $this->options['--include-archive'] = true;
        return $this;
    }

    public function filterVault(string|OnePasswordVaultId $vault): ListItemsCommand
    {
        $this->options['--vault'] = (string) $vault;
        return $this;
    }

    /**
     * @return OnePasswordListingItemCollection
     * @throws CommandFailedException
     */
    public function execute(): OnePasswordListingItemCollection
    {
        $command = [
            'op', 'item', 'list',
            ...$this->commandHelper->processOptionsToCommandArray($this->options)
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CommandFailedException($process);
        }

        return new OnePasswordListingItemCollection($this->serializer->deserialize(
            $process->getOutput(),
            OnePasswordListingItem::class . '[]',
            'json'
        ));
    }
}
