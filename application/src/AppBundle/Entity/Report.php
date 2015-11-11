<?php


namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity()
 */
class Report
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var Session
     *
     * @ORM\OneToOne(targetEntity="Playbloom\Trainer\AppBundle\Entity\Session")
     */
    private $session;

    /**
     * @var Feedback
     *
     * @ORM\OneToMany(targetEntity="Playbloom\Trainer\AppBundle\Entity\Feedback", mappedBy="report")
     */
    private $feedbacks;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return Feedback
     */
    public function getFeedbacks()
    {
        return $this->feedbacks;
    }

    /**
     * @param Feedback $feedbacks
     */
    public function setFeedbacks($feedbacks)
    {
        $this->feedbacks = $feedbacks;
    }


}