<?php
namespace AppBundle\Vendor\Api;

use AppBundle\Repository\OAuthTokenRepository;
use Google_Client;
use Google_Http_Request;
use Google_Service_YouTube;
use Google_Service_YouTube_PlaylistItemListResponse;
use GuzzleHttp\Psr7\Response;

class Youtube
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var OAuthTokenRepository
     */
    private $oauthTokenRepository;

    /**
     * YoutubeAPI constructor.
     * @param $apiKey
     * @param $clientId
     * @param $clientSecret
     * @param OAuthTokenRepository $oauthTokenRepository
     */
    public function __construct($apiKey, $clientId, $clientSecret, OAuthTokenRepository $oauthTokenRepository)
    {
        $this->apiKey = $apiKey;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->oauthTokenRepository = $oauthTokenRepository;
    }

    public function getOAuthClient(){
        $token = $this->oauthTokenRepository->getLastToken();


        $client = new Google_Client();
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');

        if ($token) {
            $client->setAccessToken($token->getAccessToken());
        }

        $client->setAccessType("offline");

//        if($client->isAccessTokenExpired()) {
//            $client->refreshToken($token->getRefreshToken());
//        }

        $redirect = 'http://localhost/app_dev.php/youtube/token';
        $client->setRedirectUri($redirect);
        return $client;
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
        $searchResponse = $youtube->playlistItems->listPlaylistItems('id,snippet,contentDetails', array(
            'playlistId' => $playlistId,
            'maxResults' => $maxResult,
        ));
        return $searchResponse['items'];
    }

    /**
     * @param $channelId
     * @param $maxResult
     * @return Google_Service_YouTube_PlaylistItemListResponse
     */
    public function getVideosFromChannel($channelId, $maxResult)
    {
        $client = $this->getClient();
        $youtube = new Google_Service_YouTube($client);
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'channelId' => $channelId,
            'maxResults' => $maxResult,
            'type' => 'video'
        ));
        return $searchResponse['items'];
    }

    /**
     * @param $videoID
     * @return mixed
     */
    public function getVideo($videoID)
    {
        $client = $this->getClient();

        $youtube = new Google_Service_YouTube($client);
        $searchResponse = $youtube->videos->listVideos('id,snippet,contentDetails', array(
            'id' => $videoID
        ));
        return $searchResponse['items'][0];
    }

    function getCaptions($videoId) {
        $client = $this->getOAuthClient();

        $youtube = new Google_Service_YouTube($client);
        // Call the YouTube Data API's captions.list method to retrieve video caption tracks.
        $captions = $youtube->captions->listCaptions("snippet", $videoId);
        return $captions;
    }

    /**
     * @param $captionId
     * @return Response
     */
    function downloadCaption($captionId)
    {
        $client = $this->getOAuthClient();

        $youtube = new Google_Service_YouTube($client);

        $captions = $youtube->captions->download($captionId, array(
            'tfmt' => "srt",
            'alt' => 'media'
        ));
        return $captions;
    }
}