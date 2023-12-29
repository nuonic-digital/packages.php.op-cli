<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('nuonic_one_password_cli');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('default_account')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
