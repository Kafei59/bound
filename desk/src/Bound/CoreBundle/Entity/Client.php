<?php

namespace Bound\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bound\CoreBundle\Entity\ClientRepository")
 */
class Client
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /** @ORM\Column(name="twitter_id", type="string", length=255, nullable=true) */
    protected $twitter_id;

    /** @ORM\Column(name="twitter_access_token", type="string", length=255, nullable=true) */
    protected $twitter_access_token;

    /** @ORM\Column(name="instagram_id", type="string", length=255, nullable=true) */
    protected $instagram_id;

    /** @ORM\Column(name="instagram_access_token", type="string", length=255, nullable=true) */
    protected $instagram_access_token;

    /** @ORM\Column(name="linkedin_id", type="string", length=255, nullable=true) */
    protected $linkedin_id;

    /** @ORM\Column(name="linkedin_access_token", type="string", length=255, nullable=true) */
    protected $linkedin_access_token;

    /** @ORM\Column(name="strava_id", type="string", length=255, nullable=true) */
    protected $strava_id;

    /** @ORM\Column(name="strava_access_token", type="string", length=255, nullable=true) */
    protected $strava_access_token;

    /** @ORM\Column(name="deezer_id", type="string", length=255, nullable=true) */
    protected $deezer_id;

    /** @ORM\Column(name="deezer_access_token", type="string", length=255, nullable=true) */
    protected $deezer_access_token;

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
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return Client
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return Client
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set twitterId
     *
     * @param string $twitterId
     *
     * @return Client
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * Set twitterAccessToken
     *
     * @param string $twitterAccessToken
     *
     * @return Client
     */
    public function setTwitterAccessToken($twitterAccessToken)
    {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitterAccessToken
     *
     * @return string
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }

    /**
     * Set instagramId
     *
     * @param string $instagramId
     *
     * @return Client
     */
    public function setInstagramId($instagramId)
    {
        $this->instagram_id = $instagramId;

        return $this;
    }

    /**
     * Get instagramId
     *
     * @return string
     */
    public function getInstagramId()
    {
        return $this->instagram_id;
    }

    /**
     * Set instagramAccessToken
     *
     * @param string $instagramAccessToken
     *
     * @return Client
     */
    public function setInstagramAccessToken($instagramAccessToken)
    {
        $this->instagram_access_token = $instagramAccessToken;

        return $this;
    }

    /**
     * Get instagramAccessToken
     *
     * @return string
     */
    public function getInstagramAccessToken()
    {
        return $this->instagram_access_token;
    }

    /**
     * Set linkedinId
     *
     * @param string $linkedinId
     *
     * @return Client
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedin_id = $linkedinId;

        return $this;
    }

    /**
     * Get linkedinId
     *
     * @return string
     */
    public function getLinkedinId()
    {
        return $this->linkedin_id;
    }

    /**
     * Set linkedinAccessToken
     *
     * @param string $linkedinAccessToken
     *
     * @return Client
     */
    public function setLinkedinAccessToken($linkedinAccessToken)
    {
        $this->linkedin_access_token = $linkedinAccessToken;

        return $this;
    }

    /**
     * Get linkedinAccessToken
     *
     * @return string
     */
    public function getLinkedinAccessToken()
    {
        return $this->linkedin_access_token;
    }

    /**
     * Set stravaId
     *
     * @param string $stravaId
     *
     * @return Client
     */
    public function setStravaId($stravaId)
    {
        $this->strava_id = $stravaId;

        return $this;
    }

    /**
     * Get stravaId
     *
     * @return string
     */
    public function getStravaId()
    {
        return $this->strava_id;
    }

    /**
     * Set stravaAccessToken
     *
     * @param string $stravaAccessToken
     *
     * @return Client
     */
    public function setStravaAccessToken($stravaAccessToken)
    {
        $this->strava_access_token = $stravaAccessToken;

        return $this;
    }

    /**
     * Get stravaAccessToken
     *
     * @return string
     */
    public function getStravaAccessToken()
    {
        return $this->strava_access_token;
    }

    /**
     * Set deezerId
     *
     * @param string $deezerId
     *
     * @return Client
     */
    public function setDeezerId($deezerId)
    {
        $this->deezer_id = $deezerId;

        return $this;
    }

    /**
     * Get deezerId
     *
     * @return string
     */
    public function getDeezerId()
    {
        return $this->deezer_id;
    }

    /**
     * Set deezerAccessToken
     *
     * @param string $deezerAccessToken
     *
     * @return Client
     */
    public function setDeezerAccessToken($deezerAccessToken)
    {
        $this->deezer_access_token = $deezerAccessToken;

        return $this;
    }

    /**
     * Get deezerAccessToken
     *
     * @return string
     */
    public function getDeezerAccessToken()
    {
        return $this->deezer_access_token;
    }
}
