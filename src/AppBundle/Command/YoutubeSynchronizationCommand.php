<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YoutubeSynchronizationCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('itworks:youtube:sync')
            ->setDescription('Grab data from Youtube')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('AppBundle\Service\Api\Youtube')->synchronization();
    }
}