<?php
namespace AppBundle\Tests\Service\Api;

use AppBundle\Entity\Video;
use AppBundle\Repository\VideoRepository;
use AppBundle\Service\Api\Youtube;
use AppBundle\Vendor\Api\Youtube as V_Youtube;
use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit_Framework_TestCase;
use stdClass;

class YoutubeTest extends PHPUnit_Framework_TestCase
{

    public function testGetOAuthClientNullCaptions()
    {

        $em = Mockery::mock(EntityManager::class);

        $video = new stdClass();
        $video->id = new stdClass();
        $video->id->videoId = 2;

        $contentDetails = Mockery::mock(stdClass::class);
        $contentDetails->shouldReceive("getDuration")->andReturn('PT5M0S');

        $snippet = Mockery::mock(stdClass::class);
        $snippet->shouldReceive("getTitle")->andReturn("Hello world");
        $snippet->shouldReceive("getDescription")->andReturn("Hey mate, c'est Antho !");
        $snippet->shouldReceive("getPublishedAt")->andReturn("2017-10-19T14:30:02.000Z");

        $details = Mockery::mock(stdClass::class);
        $details->shouldReceive("getContentDetails")->andReturn($contentDetails);
        $details->shouldReceive("getSnippet")->andReturn($snippet);

        $videoRepository = Mockery::mock(VideoRepository::class);
        $videoRepository->shouldReceive("findOneBy")
            ->andReturnNull();

        $vYoutube = Mockery::mock(V_Youtube::class);
        $vYoutube->shouldReceive("getVideosFromChannel")
            ->andReturn(
                [$video]
            );
        $vYoutube->shouldReceive("getVideo")
            ->andReturn($details);
        $vYoutube->shouldReceive("getCaptions")
            ->andReturn([]);

        $em->shouldReceive("getRepository")
            ->andReturn($videoRepository);

        $em->shouldReceive("persist")
            ->with(Mockery::on(function (Video $video) {
                    $this->assertEquals($video->getTitle(), 'Hello world');
                    $this->assertEquals($video->getDescription(), 'Hey mate, c\'est Antho !');
                    $this->assertEquals($video->getPublishedAt(), new  \DateTime('2017-10-19T14:30:02.000Z'));
                    $this->assertEquals($video->getDuration(), 300);
                    $this->assertEquals($video->getYoutubeId(), 2);
                    $this->assertEquals($video->getStatus(), Video::STATUS_DONE);
                    $this->assertNull($video->getCaptions());
                    return true;
                })
            );

        $em->shouldReceive("flush")
            ->andReturnNull();

        $service = new Youtube("apiKey", $em, $vYoutube);
        $service->synchronization();
    }

    public function testGetOAuthClient()
    {

        $em = Mockery::mock(EntityManager::class);

        $video = new stdClass();
        $video->id = new stdClass();
        $video->id->videoId = 2;

        $contentDetails = Mockery::mock(stdClass::class);
        $contentDetails->shouldReceive("getDuration")->andReturn('PT6M0S');

        $snippet = Mockery::mock(stdClass::class);
        $snippet->shouldReceive("getTitle")->andReturn("Hello world 2");
        $snippet->shouldReceive("getDescription")->andReturn("Hey mate, c'est Antho !");
        $snippet->shouldReceive("getPublishedAt")->andReturn("2018-10-19T14:30:02.000Z");

        $details = Mockery::mock(stdClass::class);
        $details->shouldReceive("getContentDetails")->andReturn($contentDetails);
        $details->shouldReceive("getSnippet")->andReturn($snippet);

        $caption = [];
        $caption['id'] = 3;

        $body = Mockery::mock(stdClass::class);
        $body->shouldReceive("getContents")->andReturn("Sur ce, je retourne coder !");

        $srt = Mockery::mock(stdClass::class);
        $srt->shouldReceive("getBody")->andReturn($body);

        $videoRepository = Mockery::mock(VideoRepository::class);
        $videoRepository->shouldReceive("findOneBy")
            ->andReturnNull();

        $vYoutube = Mockery::mock(V_Youtube::class);
        $vYoutube->shouldReceive("getVideosFromChannel")
            ->andReturn(
                [$video]
            );
        $vYoutube->shouldReceive("getVideo")
            ->andReturn($details);
        $vYoutube->shouldReceive("getCaptions")
            ->andReturn([$caption]);
        $vYoutube->shouldReceive("downloadCaption")
            ->andReturn($srt);

        $em->shouldReceive("getRepository")
            ->andReturn($videoRepository);

        $em->shouldReceive("persist")
            ->with(Mockery::on(function (Video $video) {
                    $this->assertEquals($video->getTitle(), 'Hello world 2');
                    $this->assertEquals($video->getDescription(), 'Hey mate, c\'est Antho !');
                    $this->assertEquals($video->getPublishedAt(), new  \DateTime('2018-10-19T14:30:02.000Z'));
                    $this->assertEquals($video->getDuration(), 360);
                    $this->assertEquals($video->getYoutubeId(), 2);
                    $this->assertEquals($video->getStatus(), Video::STATUS_DONE);
                    $this->assertEquals($video->getCaptions(), "Sur ce, je retourne coder !");
                    return true;
                })
            );

        $em->shouldReceive("flush")
            ->andReturnNull();

        $service = new Youtube("apiKey", $em, $vYoutube);
        $service->synchronization();
    }
}