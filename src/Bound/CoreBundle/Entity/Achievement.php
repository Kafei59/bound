<?php

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achievement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\CoreBundle\Entity\AchievementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Achievement
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;


    public function toArray() {
        return array(
            'title' => $this->title,
            'salt' => $this->salt,
            'content' => $this->content,
            'points' => $this->points
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
     * @return Achievement
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
     * Set content
     *
     * @param string $content
     *
     * @return Achievement
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Achievement
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Achievement
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
