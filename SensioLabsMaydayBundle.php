<?php

namespace SensioLabs\Bundle\MaydayBundle;

use SensioLabs\Bundle\MaydayBundle\DependencyInjection\Compiler\NotifierPass;
use SensioLabs\Bundle\MaydayBundle\DependencyInjection\Compiler\ReactPass;
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
        $container->addCompilerPass(new NotifierPass());
        $container->addCompilerPass(new ReactPass($this->getPath()));
    }
}
