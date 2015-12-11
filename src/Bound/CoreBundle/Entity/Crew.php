<?php

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var array
     *
     * @ORM\Column(name="members", type="array")
     */
    private $members;


    public function toArray() {
        return get_object_vars($this);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function slugifyTitle() {
        $slug = str_replace(' ', '+', $this->title);
        $slug = mb_strtolower($slug, "utf-8");

        $this->slug = $slug;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function assertEntity() {
        $attrs = $this->toArray();
        foreach ($attrs as $key => $attr) {
            if ($key != 'id' and $attr == NULL) {
                throw new HttpException(400, "Entity properties cannot be null.");
            }
        }
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Crew
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
