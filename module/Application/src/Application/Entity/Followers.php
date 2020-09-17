<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Followers
 *
 * @ORM\Table(name="followers", indexes={@ORM\Index(name="userid", columns={"userid"}), @ORM\Index(name="followsid", columns={"followsid"})})
 * @ORM\Entity
 */
class Followers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=false)
     */
    private $updatedat;

    /**
     * @var \Application\Entity\Userregistration
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Userregistration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="userid")
     * })
     */
    private $userid;

    /**
     * @var \Application\Entity\Userregistration
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Userregistration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="followsid", referencedColumnName="userid")
     * })
     */
    private $followsid;



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
     * Set updatedat
     *
     * @param \DateTime $updatedat
     *
     * @return Followers
     */
    public function setUpdatedat($updatedat)
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    /**
     * Get updatedat
     *
     * @return \DateTime
     */
    public function getUpdatedat()
    {
        return $this->updatedat;
    }

    /**
     * Set userid
     *
     * @param \Application\Entity\Userregistration $userid
     *
     * @return Followers
     */
    public function setUserid(\Application\Entity\Userregistration $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \Application\Entity\Userregistration
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set followsid
     *
     * @param \Application\Entity\Userregistration $followsid
     *
     * @return Followers
     */
    public function setFollowsid(\Application\Entity\Userregistration $followsid = null)
    {
        $this->followsid = $followsid;

        return $this;
    }

    /**
     * Get followsid
     *
     * @return \Application\Entity\Userregistration
     */
    public function getFollowsid()
    {
        return $this->followsid;
    }
}
