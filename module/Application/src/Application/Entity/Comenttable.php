<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comenttable
 *
 * @ORM\Table(name="comenttable", indexes={@ORM\Index(name="commentid", columns={"commentid"}), @ORM\Index(name="blogid", columns={"blogid"}), @ORM\Index(name="userid", columns={"userid"})})
 * @ORM\Entity
 */
class Comenttable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="commentid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentid;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=100, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
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
     * Get commentid
     *
     * @return integer
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comenttable
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     *
     * @return Comenttable
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Comenttable
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
     * @return Comenttable
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
     * @return Comenttable
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
