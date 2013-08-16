<?php

namespace SensioLabs\Bundle\MaydayBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers notifiers to the chain.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class NotifierPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sensiolabs_mayday.notifier.chain')) {
            return;
        }

        $definition = $container->getDefinition('sensiolabs_mayday.notifier.chain');
        foreach ($container->findTaggedServiceIds('sensiolabs_mayday.notifier') as $id => $tags) {
            $definition->addMethodCall('register', array(new Reference($id)));
        }
    }
}
