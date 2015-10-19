<?php

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crew
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\CoreBundle\Entity\CrewRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Crew
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="members", type="array")
     */
    private $members;


    public function toArray() {
        return array(
            'title' => $this->title,
            'members' => $this->members
        );
    }

    /**
     * @ORM\PrePersist
     */
    public function saltifyTitle() {
        $salt = str_replace(' ', '+', $this->title);
        $salt = mb_strtolower($salt, "utf-8");

        $this->salt = $salt;
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
     * Set title
     *
     * @param string $title
     *
     * @return Crew
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set members
     *
     * @param array $members
     *
     * @return Crew
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Get members
     *
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Crew
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
}
