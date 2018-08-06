<?php
namespace AppBundle\Service\Api;

use AppBundle\Entity\OAuthToken;
use AppBundle\Entity\Video;
use AppBundle\Repository\OAuthTokenRepository;
use AppBundle\Vendor\Api\Youtube as V_Youtube;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

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
     * @param $clientId
     * @param $clientSecret
     * @param OAuthTokenRepository $oauthTokenRepository
     * @param $channelId
     * @param EntityManager $em
     */
    public function __construct(
        $apiKey,
        $clientId,
        $clientSecret,
        $channelId,
        EntityManager $em
    ) {
        $this->youtube = new V_Youtube($apiKey, $clientId, $clientSecret, $em->getRepository(OAuthToken::class));
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

            $v = $this->em->getRepository(Video::class)->findOneBy(array(
               'youtubeId' => $id
            ));
            if (!$v) {
                $v = new Video();
            }
            $v->setTitle($details->getSnippet()->getTitle())
                ->setDescription($details->getSnippet()->getDescription())
                ->setYoutubeId($id)
                ->setPublishedAt(new \DateTime($details->getSnippet()->getPublishedAt()))
                ->setDuration($finalDuration)
                ->setStatus(Video::STATUS_DONE)
            ;

            $captions = $this->youtube->getCaptions($id);
            foreach($captions as $caption) {
                $srt = $this->youtube->downloadCaption($caption['id']);
                $v->setCaptions($srt->getBody()->getContents());
            }

            $this->em->persist($v);
        }
        $this->em->flush();
    }
}