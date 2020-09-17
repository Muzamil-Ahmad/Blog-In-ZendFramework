<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Privacy
 *
 * @ORM\Table(name="privacy", indexes={@ORM\Index(name="privacy_ibfk_1", columns={"userid"}), @ORM\Index(name="accessid", columns={"accessid"})})
 * @ORM\Entity
 */
class Privacy
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
     *   @ORM\JoinColumn(name="accessid", referencedColumnName="userid")
     * })
     */
    private $accessid;



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
     * Set userid
     *
     * @param \Application\Entity\Userregistration $userid
     *
     * @return Privacy
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
     * Set accessid
     *
     * @param \Application\Entity\Userregistration $accessid
     *
     * @return Privacy
     */
    public function setAccessid(\Application\Entity\Userregistration $accessid = null)
    {
        $this->accessid = $accessid;

        return $this;
    }

    /**
     * Get accessid
     *
     * @return \Application\Entity\Userregistration
     */
    public function getAccessid()
    {
        return $this->accessid;
    }
}
