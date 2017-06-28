<?php
namespace AppBundle\Vendor\Api;

use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_PlaylistItemListResponse;

class Youtube
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * YoutubeAPI constructor.
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    /**
     * @return Google_Client
     */
    private function getClient()
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->apiKey);
        return $client;
    }

    /**
     * @param $playlistId
     * @param $maxResult
     * @return Google_Service_YouTube_PlaylistItemListResponse
     */
    public function getVideosFromPlaylist($playlistId, $maxResult)
    {
        $client = $this->getClient();
        $youtube = new Google_Service_YouTube($client);
        $searchResponse = $youtube->playlistItems->listPlaylistItems('id,snippet', array(
            'playlistId' => $playlistId,
            'maxResults' => $maxResult,
        ));
        return $searchResponse['items'];
    }
}