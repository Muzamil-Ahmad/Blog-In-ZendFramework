<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blogtable
 *
 * @ORM\Table(name="blogtable", indexes={@ORM\Index(name="blogid", columns={"blogid"}), @ORM\Index(name="blogid_2", columns={"blogid"}), @ORM\Index(name="userid", columns={"userid"})})
 * @ORM\Entity
 */
class Blogtable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="blogid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $blogid;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="userpost", type="string", length=50000, nullable=true)
     */
    private $userpost;

    /**
     * @var string
     *
     * @ORM\Column(name="userphoto", type="string", length=100, nullable=true)
     */
    private $userphoto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="postdate", type="datetime", nullable=true)
     */
    private $postdate;

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
     * Get blogid
     *
     * @return integer
     */
    public function getBlogid()
    {
        return $this->blogid;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Blogtable
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
     * Set userpost
     *
     * @param string $userpost
     *
     * @return Blogtable
     */
    public function setUserpost($userpost)
    {
        $this->userpost = $userpost;

        return $this;
    }

    /**
     * Get userpost
     *
     * @return string
     */
    public function getUserpost()
    {
        return $this->userpost;
    }

    /**
     * Set userphoto
     *
     * @param string $userphoto
     *
     * @return Blogtable
     */
    public function setUserphoto($userphoto)
    {
        $this->userphoto = $userphoto;

        return $this;
    }

    /**
     * Get userphoto
     *
     * @return string
     */
    public function getUserphoto()
    {
        return $this->userphoto;
    }

    /**
     * Set postdate
     *
     * @param \DateTime $postdate
     *
     * @return Blogtable
     */
    public function setPostdate($postdate)
    {
        $this->postdate = $postdate;

        return $this;
    }

    /**
     * Get postdate
     *
     * @return \DateTime
     */
    public function getPostdate()
    {
        return $this->postdate;
    }

    /**
     * Set userid
     *
     * @param \Application\Entity\Userregistration $userid
     *
     * @return Blogtable
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
