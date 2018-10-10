<?php
namespace AppBundle\Tests\Service\Api;

use AppBundle\Repository\OAuthTokenRepository;
use AppBundle\Service\Api\Youtube;
use AppBundle\Vendor\Api\Youtube as V_Youtube;
use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit_Framework_TestCase;

class YoutubeTest extends PHPUnit_Framework_TestCase
{

    public function testGetOAuthClient()
    {

        $em = Mockery::mock(EntityManager::class);

        $video = new \stdClass();
        $video->id = new \stdClass();
        $video->id->videoId = 2;

        $OAuthTokenRepository = Mockery::mock(OAuthTokenRepository::class);

        $vYoutube = Mockery::mock(V_Youtube::class);
        $vYoutube->shouldReceive("getVideosFromChannel")
            ->andReturn(
                [$video]
            );

        $em->shouldReceive("getRepository")
            ->andReturn($OAuthTokenRepository);

        $service = new Youtube("apiKey", $em, $vYoutube);
        $service->synchronization();
    }
}