<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Video;
use AppBundle\Entity\User;

/**
 * UserWatchedVideo
 *
 * @ORM\Table(name="user_watched_video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserWatchedVideoRepository")
 */
class UserWatchedVideo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Video", inversedBy="userWatchedVideos")
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id")
     */
    private $video;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userWatchedVideos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserWatchedVideo
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set video
     *
     * @param Video $video
     *
     * @return UserWatchedVideo
     */
    public function setVideo(Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return UserWatchedVideo
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
