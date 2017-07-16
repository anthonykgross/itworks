<?php
namespace AppBundle\Service\Api;

use AppBundle\Entity\Video;
use AppBundle\Vendor\Api\Youtube as V_Youtube;
use Doctrine\ORM\EntityManager;

class Youtube
{
    /**
     * @var V_Youtube
     */
    private $youtube;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var String
     */
    private $channelId;

    /**
     * Youtube constructor.
     * @param $apiKey
     * @param $channelId
     * @param EntityManager $em
     */
    public function __construct($apiKey, $channelId, EntityManager $em)
    {
        $this->youtube = new V_Youtube($apiKey);
        $this->em = $em;
        $this->channelId = $channelId;
    }

    /**
     * @return V_Youtube
     */
    public function getInstance()
    {
        return $this->youtube;
    }

    /**
     *
     */
    public function synchronization()
    {
        $videos = $this->youtube->getVideosFromChannel($this->channelId, 50);

        foreach ($videos as $video) {
            $id = $video->id->videoId;
            $details = $this->youtube->getVideo($id);

            $duration = new \DateInterval($details->getContentDetails()->getDuration());
            $finalDuration = $duration->h*3600+$duration->i*60+$duration->s;

            $v = new Video();
            $v->setTitle($details->getSnippet()->getTitle())
                ->setDescription($details->getSnippet()->getDescription())
                ->setYoutubeId($id)
                ->setPublishedAt(new \DateTime($details->getSnippet()->getPublishedAt()))
                ->setDuration($finalDuration)
                ->setStatus(Video::STATUS_DONE)
            ;

            $this->em->persist($v);
        }
        $this->em->flush();
    }
}