<?php

namespace SensioLabs\Bundle\MaydayBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Mayday DIC extension.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class SensioLabsMaydayExtension extends Extension
{
    /**
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('listener.xml');
        $loader->load('notifier.xml');
        $loader->load('server.xml');
        $loader->load('twig.xml');

        foreach ($this->processConfiguration(new Configuration(), $configs) as $key => $value) {
            $container->setParameter('sensiolabs_mayday.config.'.$key, $value);
        }
    }
}
