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
class ReactBroadcastCommand extends AbstractReactCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mayday:react:broadcast')
            ->addArgument('type', InputArgument::REQUIRED, 'Command name')
            ->addArgument('parameters', InputArgument::OPTIONAL, 'Command arguments as json', '[]')
            ->setDescription('Broadcasts command through react.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->getReactServer()->ping()) {
            $this->getReactServer()->broadcast($input->getArgument('type'), json_decode($input->getArgument('parameters')));
        } else {
            $output->writeln('<error>Failed to ping react server.</error>');
        }
    }
}
