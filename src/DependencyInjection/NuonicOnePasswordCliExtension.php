<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class NuonicOnePasswordCliExtension extends Extension
{

    public function prepend(ContainerBuilder $container): void
    {
        if (empty($frameworkConfiguration = $container->getExtensionConfig('framework'))) {
            return;
        }

        if (!isset($frameworkConfiguration['serializer']['enabled'])) {
            $container->prependExtensionConfig('framework', ['serializer' => ['enabled' => true]]);
        }
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config/')
        );
        $loader->load('services.xml');
    }
}
