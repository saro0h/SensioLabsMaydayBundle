<?php

namespace SensioLabs\Bundle\MaydayBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
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
        $loader->load('react.xml');

        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('sensiolabs_mayday.react.port', $config['react_port']);
        $container->setParameter('sensiolabs_mayday.config.priorities', $config['priorities']);
    }
}
