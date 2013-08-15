<?php

namespace SensioLabs\Bundle\MaydayBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Problem creation command.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ReactRestartCommand extends AbstractReactCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mayday:react:restart')
            ->setDescription('Restarts react server.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->getReactServer()->ping()) {
            if ($this->getReactServer()->stop()) {
                $output->writeln('<info>React server is now stopped.</info>');

                if ($this->getReactServer()->start()) {
                    $output->writeln('<info>React server is now started.</info>');
                } else {
                    $output->writeln('<error>React server failed to start.</error>');
                }
            } else {
                $output->writeln('<error>React server failed to stop.</error>');
            }
        }
    }
}
