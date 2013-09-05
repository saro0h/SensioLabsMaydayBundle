<?php

namespace SensioLabs\Bundle\MaydayBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Registers react parameters.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ReactPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $bundlePath;

    /**
     * @param string $bundlePath
     */
    public function __construct($bundlePath)
    {
        $this->bundlePath = $bundlePath;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->setParameter('sensiolabs_mayday.config.react_pid_file_path', $this->bundlePath.'/Resources/react/.pid');
        $container->setParameter('sensiolabs_mayday.config.react_run_file_path', $this->bundlePath.'/Resources/react/run.php');
    }
}
