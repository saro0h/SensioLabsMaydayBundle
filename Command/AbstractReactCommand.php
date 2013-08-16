<?php

namespace SensioLabs\Bundle\MaydayBundle\Command;

use SensioLabs\Bundle\MaydayBundle\Server\ReactServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Abstract react command.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractReactCommand extends ContainerAwareCommand
{
    /**
     * @return ReactServer
     */
    protected function getReactServer()
    {
        return $this->getContainer()->get('sensiolabs_mayday.server.react');
    }

    /**
     * Pings react server.
     *
     * @param OutputInterface $output
     *
     * @return boolean
     */
    protected function pingServer(OutputInterface $output)
    {
        if (!$this->getReactServer()->ping()) {
            $output->writeln('<error>Failed to ping react server.</error>');

            return false;
        }

        return true;
    }

    /**
     * Starts react server.
     *
     * @param OutputInterface $output
     */
    protected function startServer(OutputInterface $output)
    {
        if ($this->getReactServer()->start()) {
            $output->writeln('<info>React server is now started.</info>');
        } else {
            $output->writeln('<comment>React server is already started.</comment>');
        }
    }

    /**
     * Stops react server.
     *
     * @param OutputInterface $output
     */
    protected function stopServer(OutputInterface $output)
    {
        if ($this->getReactServer()->ping()) {
            $this->getReactServer()->broadcast('server.stop');
        }

        if ($this->getReactServer()->stop()) {
            $output->writeln('<info>React server is now stopped.</info>');
        } else {
            $output->writeln('<comment>React server is already stopped.</comment>');
        }
    }
}
