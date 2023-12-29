<?php

namespace Test\Integration\Command;

use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\ListItemsCommand;
use Nuonic\OnePasswordCli\Model\OnePasswordItemId;
use Nuonic\OnePasswordCli\Serializer\CollectionDenormalizer;
use Nuonic\OnePasswordCli\Serializer\ModelDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class ListItemsCommandTest extends TestCase
{

    private ListItemsCommand $command;

    protected function setUp(): void
    {
        $serializer = new Serializer(
            [new DateTimeNormalizer(), new ArrayDenormalizer(), new CollectionDenormalizer(), new ModelDenormalizer()],
            [new JsonEncoder()]
        );
        $commandHelper = new CommandHelper();
        $this->command = new ListItemsCommand(
            $serializer,
            $commandHelper
        );
    }

    public function testFilterCategories(): void
    {
        $result = $this->command->filterCategories('Secure Note')->execute();

        $this->assertCount(1, $result);
        $this->assertEquals('secret note', $result->find(new OnePasswordItemId('22jr2fw7k4y6dizgc3h22no65e'))->title);
    }

    public function testFilterVault(): void
    {
        $result = $this->command->filterVault('packages.php.op-cli-integration-2')->execute();

        $this->assertCount(2, $result);
        $this->assertEquals('wondersite', $result->find(new OnePasswordItemId('r7fvoytpbo3widghmudydjqkv4'))->title);
    }

    public function testExecuteWithoutFilter(): void
    {
        $result = $this->command->execute();

        $this->assertCount(5, $result);
        $this->assertEquals('password', $result->find(new OnePasswordItemId('5cgf63qf36i2jukjg4duszjv6a'))->title);
    }

    public function testOnlyFavorites(): void
    {
        $result = $this->command->onlyFavorites()->execute();

        $this->assertCount(1, $result);
        $this->assertEquals('favourite', $result->find(new OnePasswordItemId('7i3cai63476wgrjeofixztf3wy'))->title);
    }

    public function testIncludeArchive(): void
    {
        $result = $this->command->includeArchive()->execute();

        $this->assertCount(6, $result);
        $this->assertEquals('archived', $result->find(new OnePasswordItemId('cimyve4ebwfyhdtuc4nuwtynfe'))->title);
    }

    public function testFilterTags(): void
    {
        $result = $this->command->filterTags('test')->execute();

        $this->assertCount(1, $result);
        $this->assertEquals('tagged', $result->find( new OnePasswordItemId('h45yutrw5bir5wrqtvzb67j4f4'))->title);
    }
}
