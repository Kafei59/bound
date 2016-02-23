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
     * @ORM\ManyToOne(targetEntity="Bound\CoreBundle\Entity\Crew", inversedBy="members")
     * @ORM\JoinColumn(name="crew_id", referencedColumnName="id")
     */
    private $crew;

    /**
     * @ORM\Column(name="friends", type="array", nullable=true)
     **/
    private $friends;

    /**
     * @ORM\Column(name="achievements", type="array", nullable=true)
     **/
    private $achievements;

    /**
     * @ORM\OneToMany(targetEntity="Bound\CoreBundle\Entity\Notification", mappedBy="owner")
     */
    private $notifications;
    
    public function __construct() {
        $this->friends = array();
        $this->achievements = array();
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
     * Set friends
     *
     * @param array $friends
     *
     * @return Player
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * Get friends
     *
     * @return array
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Set achievements
     *
     * @param array $achievements
     *
     * @return Player
     */
    public function setAchievements($achievements)
    {
        $this->achievements = $achievements;

        return $this;
    }

    /**
     * Get achievements
     *
     * @return array
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    public function addAchievement($achievement) {
        if (!in_array($achievement, $this->achievements, true)) {
            $this->achievements[] = $achievement;
        }

        return $this;
    }

    public function removeAchievement($achievement) {
        if (false !== $key = array_search($achievement, $this->achievements, true)) {
            unset($this->achievements[$key]);
            $this->achievements = array_values($this->achievements);
        }

        return $this;
    }
}
