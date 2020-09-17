<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tasklist
 *
 * @ORM\Table(name="tasklist")
 * @ORM\Entity
 */
class Tasklist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="taskid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $taskid;

    /**
     * @var string
     *
     * @ORM\Column(name="taskname", type="string", length=600, nullable=false)
     */
    private $taskname;

    /**
     * @var boolean
     *
     * @ORM\Column(name="taskstatus", type="boolean", nullable=false)
     */
    private $taskstatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duedate", type="date", nullable=false)
     */
    private $duedate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="completeddate", type="date", nullable=true)
     */
    private $completeddate;



    /**
     * Get taskid
     *
     * @return integer
     */
    public function getTaskid()
    {
        return $this->taskid;
    }

    /**
     * Set taskname
     *
     * @param string $taskname
     *
     * @return Tasklist
     */
    public function setTaskname($taskname)
    {
        $this->taskname = $taskname;

        return $this;
    }

    /**
     * Get taskname
     *
     * @return string
     */
    public function getTaskname()
    {
        return $this->taskname;
    }

    /**
     * Set taskstatus
     *
     * @param boolean $taskstatus
     *
     * @return Tasklist
     */
    public function setTaskstatus($taskstatus)
    {
        $this->taskstatus = $taskstatus;

        return $this;
    }

    /**
     * Get taskstatus
     *
     * @return boolean
     */
    public function getTaskstatus()
    {
        return $this->taskstatus;
    }

    /**
     * Set duedate
     *
     * @param \DateTime $duedate
     *
     * @return Tasklist
     */
    public function setDuedate($duedate)
    {
        $this->duedate = $duedate;

        return $this;
    }

    /**
     * Get duedate
     *
     * @return \DateTime
     */
    public function getDuedate()
    {
        return $this->duedate;
    }

    /**
     * Set completeddate
     *
     * @param \DateTime $completeddate
     *
     * @return Tasklist
     */
    public function setCompleteddate($completeddate)
    {
        $this->completeddate = $completeddate;

        return $this;
    }

    /**
     * Get completeddate
     *
     * @return \DateTime
     */
    public function getCompleteddate()
    {
        return $this->completeddate;
    }
}
