<?php
namespace AppBundle\Service\Api;

use AppBundle\Vendor\Api\Youtube as V_Youtube;

class Youtube
{
    /**
     * @var V_Youtube
     */
    private $youtube;

    /**
     * Youtube constructor.
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->youtube = new V_Youtube($apiKey);
    }

    /**
     * @return V_Youtube
     */
    public function getInstance()
    {
        return $this->youtube;
    }
}