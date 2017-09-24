<?php
namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FixturesCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('itworks:fixtures')
            ->setDescription('Create default data')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        #admin
        $admin = new User();
        $admin->setEmail('admin@example.com')
            ->setUsername('admin')
            ->setPlainPassword('admin')
            ->setRoles(array('ROLE_ADMIN'))
            ->setEnabled(true);
        $em->persist($admin);
        $em->flush();
    }
}