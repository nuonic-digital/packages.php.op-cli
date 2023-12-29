<?php

namespace Test\Integration\Command;

use Nuonic\OnePasswordCli\Collection\OnePasswordFieldCollection;
use Nuonic\OnePasswordCli\Command\Common\CommandHelper;
use Nuonic\OnePasswordCli\Command\GetItemCommand;
use Nuonic\OnePasswordCli\Model\OnePasswordItem;
use Nuonic\OnePasswordCli\Serializer\CollectionDenormalizer;
use Nuonic\OnePasswordCli\Serializer\ModelDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class GetItemCommandTest extends TestCase
{

    private GetItemCommand $command;

    protected function setUp(): void
    {
        $serializer = new Serializer(
            [new DateTimeNormalizer(), new CollectionDenormalizer(), new ModelDenormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
        $commandHelper = new CommandHelper();
        $this->command = new GetItemCommand(
            $serializer,
            $commandHelper
        );
    }

    public function testIncludeArchive(): void
    {
        $result = $this->command->filterVault('packages.php.op-cli-integration-2')
            ->includeArchive()
            ->execute('archived');

        $this->assertNotNull($result);
        $this->assertInstanceOf(OnePasswordItem::class, $result);
        $this->assertEquals('cimyve4ebwfyhdtuc4nuwtynfe', $result->id);
    }

    public function testFilterFields(): void
    {
        $result = $this->command->filterVault('packages.php.op-cli-integration-2')
            ->filterFields('password', 'username')
            ->execute('wondersite');

        $this->assertNotNull($result);
        $this->assertInstanceOf(OnePasswordFieldCollection::class, $result);
        $this->assertCount(2, $result);
        $this->assertEquals('password', $result->first()->id);
    }

    public function testExecute(): void
    {
        $result = $this->command->filterVault('packages.php.op-cli-integration-2')
            ->execute('wondersite');

        $this->assertNotNull($result);
        $this->assertInstanceOf(OnePasswordItem::class, $result);
        $this->assertEquals('r7fvoytpbo3widghmudydjqkv4', $result->id);
    }
}
