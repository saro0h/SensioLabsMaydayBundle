<?php

namespace SensioLabs\Bundle\MaydayBundle\Command;

use SensioLabs\Bundle\MaydayBundle\React\Server;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Abstract react command.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractReactCommand extends ContainerAwareCommand
{
    /**
     * @return Server
     */
    protected function getReactServer()
    {
        return $this->getContainer()->get('sensiolabs_mayday.react.server');
    }
}
