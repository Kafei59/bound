<?php

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\CoreBundle\Entity\PlayerRepository")
 */
class Player
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Bound\CoreBundle\Entity\User", inversedBy="player")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="Bound\CoreBundle\Entity\Player", mappedBy="player")
     */
    private $friends;

    /**
     * @ORM\ManyToOne(targetEntity="Bound\CoreBundle\Entity\Crew", inversedBy="members")
     * @ORM\JoinColumn(name="crew_id", referencedColumnName="id")
     */
    private $crew;

    /**
     * @ORM\OneToMany(targetEntity="Bound\CoreBundle\Entity\Achievement", mappedBy="player")
     */
    private $achievements;

    public function __construct() {
        $this->achievements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set owner
     *
     * @param \Bound\CoreBundle\Entity\User $owner
     *
     * @return Player
     */
    public function setOwner(\Bound\CoreBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Bound\CoreBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add friend
     *
     * @param \Bound\CoreBundle\Entity\Player $friend
     *
     * @return Player
     */
    public function addFriend(\Bound\CoreBundle\Entity\Player $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \Bound\CoreBundle\Entity\Player $friend
     */
    public function removeFriend(\Bound\CoreBundle\Entity\Player $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Set crew
     *
     * @param \Bound\CoreBundle\Entity\Crew $crew
     *
     * @return Player
     */
    public function setCrew(\Bound\CoreBundle\Entity\Crew $crew = null)
    {
        $this->crew = $crew;

        return $this;
    }

    /**
     * Get crew
     *
     * @return \Bound\CoreBundle\Entity\Crew
     */
    public function getCrew()
    {
        return $this->crew;
    }

    /**
     * Add achievement
     *
     * @param \Bound\CoreBundle\Entity\Achievement $achievement
     *
     * @return Player
     */
    public function addAchievement(\Bound\CoreBundle\Entity\Achievement $achievement)
    {
        $this->achievements[] = $achievement;

        return $this;
    }

    /**
     * Remove achievement
     *
     * @param \Bound\CoreBundle\Entity\Achievement $achievement
     */
    public function removeAchievement(\Bound\CoreBundle\Entity\Achievement $achievement)
    {
        $this->achievements->removeElement($achievement);
    }

    /**
     * Get achievements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAchievements()
    {
        return $this->achievements;
    }
}
