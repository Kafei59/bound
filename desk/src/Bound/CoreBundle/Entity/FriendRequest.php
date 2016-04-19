<?php

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FriendRequest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\CoreBundle\Entity\FriendRequestRepository")
 */
class FriendRequest
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
     * @ORM\OneToOne(targetEntity="Bound\CoreBundle\Entity\Player")
     */
    private $from;

    /**
     * @ORM\OneToOne(targetEntity="Bound\CoreBundle\Entity\Player")
     */
    private $to;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct() {
        $this->date = new \Datetime();
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
     * Set from
     *
     * @param \Bound\CoreBundle\Entity\Player $from
     *
     * @return FriendRequest
     */
    public function setFrom(\Bound\CoreBundle\Entity\Player $from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return \Bound\CoreBundle\Entity\Player
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param \Bound\CoreBundle\Entity\Player $to
     *
     * @return FriendRequest
     */
    public function setTo(\Bound\CoreBundle\Entity\Player $to = null)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \Bound\CoreBundle\Entity\Player
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return FriendRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FriendRequest
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
