<?php

namespace SensioLabs\Bundle\MaydayBundle;

use SensioLabs\Bundle\MaydayBundle\DependencyInjection\Compiler\NotifierPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Mayday application bundle.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class SensioLabsMaydayBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('sensiolabs_mayday.react_pid_file_path', $this->getPath().'/Resources/react/.pid');
        $container->setParameter('sensiolabs_mayday.react_run_file_path', $this->getPath().'/Resources/react/run.php');
        $container->addCompilerPass(new NotifierPass());
    }
}
