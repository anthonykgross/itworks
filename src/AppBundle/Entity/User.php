<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\UserWatchedVideo;
use AppBundle\Entity\Note;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="UserWatchedVideo", mappedBy="user")
     */
    private $userWatchedVideos;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="user")
     */
    private $notes;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->notes = new ArrayCollection();
        $this->userWatchedVideos = new ArrayCollection();
    }

    /**
     * Add userWatchedVideo
     *
     * @param UserWatchedVideo $userWatchedVideo
     *
     * @return User
     */
    public function addUserWatchedVideo(UserWatchedVideo $userWatchedVideo)
    {
        $this->userWatchedVideos[] = $userWatchedVideo;

        return $this;
    }

    /**
     * Remove userWatchedVideo
     *
     * @param UserWatchedVideo $userWatchedVideo
     */
    public function removeUserWatchedVideo(UserWatchedVideo $userWatchedVideo)
    {
        $this->userWatchedVideos->removeElement($userWatchedVideo);
    }

    /**
     * Get userWatchedVideos
     *
     * @return Collection
     */
    public function getUserWatchedVideos()
    {
        return $this->userWatchedVideos;
    }

    /**
     * Add note
     *
     * @param Note $note
     *
     * @return User
     */
    public function addNote(Note $note)
    {
        $this->notes[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param Note $note
     */
    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * Get notes
     *
     * @return Collection
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
