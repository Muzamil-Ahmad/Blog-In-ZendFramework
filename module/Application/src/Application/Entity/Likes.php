<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likes
 *
 * @ORM\Table(name="likes", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="blogid", columns={"blogid"}), @ORM\Index(name="userid", columns={"userid"})})
 * @ORM\Entity
 */
class Likes
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
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \Application\Entity\Blogtable
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Blogtable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="blogid", referencedColumnName="blogid")
     * })
     */
    private $blogid;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Likes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set blogid
     *
     * @param \Application\Entity\Blogtable $blogid
     *
     * @return Likes
     */
    public function setBlogid(\Application\Entity\Blogtable $blogid = null)
    {
        $this->blogid = $blogid;

        return $this;
    }

    /**
     * Get blogid
     *
     * @return \Application\Entity\Blogtable
     */
    public function getBlogid()
    {
        return $this->blogid;
    }

    /**
     * Set userid
     *
     * @param \Application\Entity\Userregistration $userid
     *
     * @return Likes
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
}
