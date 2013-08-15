<?php

namespace SensioLabs\Bundle\MaydayBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SensioLabsMaydayBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('sensiolabs_mayday.react.pid_file_path', $this->getPath().'/Resources/react/.pid');
        $container->setParameter('sensiolabs_mayday.react.run_file_path', $this->getPath().'/Resources/react/run.php');
    }
}
