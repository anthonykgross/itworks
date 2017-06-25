<?php
namespace AppBundle\Command;

use AppBundle\Service\Api\Youtube as S_Youtube;
use AppBundle\Vendor\Api\Youtube as V_Youtube;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 25/06/17
 * Time: 5:08 PM
 */
class SandboxCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('itworks:sandbox')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var $youtube V_Youtube
         */
        $youtube = $this->getContainer()->get(S_Youtube::class)->getInstance();
        $videos = $youtube->getVideosFromPlaylist('PLCsa_8vz1nX60R_EX42dXsd-dBqZTArbi', 10);

        foreach ($videos as $video) {
            echo $video->getSnippet()->getTitle()."\n";
        }
    }
}