<?php

namespace Bound\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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

    public function toArray() {
        return array (
            'username' => $this->username,
            'email' => $this->email
        );
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set friends
     *
     * @param array $friends
     *
     * @return User
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
     * Set crew
     *
     * @param \Bound\CoreBundle\Entity\Crew $crew
     *
     * @return User
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
