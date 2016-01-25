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
     * @var array
     *
     * @ORM\Column(name="friends", type="array")
     */
    private $friends;

    /**
     * @ORM\ManyToOne(targetEntity="Bound\CoreBundle\Entity\Crew")
     * @ORM\JoinColumn(nullable=true)
     */
    private $crew;

    /**
     * @var array
     *
     * @ORM\Column(name="achievements", type="array")
     */
    private $achievements;

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
}
