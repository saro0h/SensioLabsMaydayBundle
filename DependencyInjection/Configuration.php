<?php

namespace SensioLabs\Bundle\MaydayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Mayday configuration builder.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sensiolabs_mayday');

        $rootNode
            ->children()
                ->scalarNode('react_host')->defaultValue('localhost')->end()
                ->scalarNode('react_port')->defaultValue(1337)->end()
                ->arrayNode('priorities')
                    ->useAttributeAsKey('id')
                    ->prototype('scalar')->cannotBeEmpty()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
