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
class ReactStartCommand extends AbstractReactCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mayday:react:start')
            ->setDescription('Starts react server.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->getReactServer()->ping()) {
            $output->writeln('<comment>React server is already started.</comment>');
        } elseif ($this->getReactServer()->start()) {
            $output->writeln('<info>React server is now started.</info>');
        } else {
            $output->writeln('<error>React server failed to start.</error>');
        }
    }
}
