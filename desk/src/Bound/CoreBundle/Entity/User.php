<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-27 14:55:06
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-29 14:53:30
 */

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\CoreBundle\Entity\UserRepository")
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
     * @ORM\OneToOne(targetEntity="Bound\CoreBundle\Entity\Player", cascade={"remove", "persist"})
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="Bound\CoreBundle\Entity\Client", cascade={"remove", "persist"})
     */
    private $client;

    public function isAdmin() {
        return in_array('ROLE_ADMIN', $this->roles) or in_array('ROLE_SUPER_ADMIN', $this->roles);
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
     * Set player
     *
     * @param \Bound\CoreBundle\Entity\Player $player
     *
     * @return User
     */
    public function setPlayer(\Bound\CoreBundle\Entity\Player $player) {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \Bound\CoreBundle\Entity\Player
     */
    public function getPlayer() {
        return $this->player;
    }

    /**
     * Set client
     *
     * @param \Bound\CoreBundle\Entity\Client $client
     *
     * @return User
     */
    public function setClient(\Bound\CoreBundle\Entity\Client $client) {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Bound\CoreBundle\Entity\Client
     */
    public function getClient() {
        return $this->client;
    }
}
