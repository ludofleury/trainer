<?php


namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use JsonSerializable;

/**
 * @ORM\Entity()
 */
class Report implements JsonSerializable
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
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var Session
     *
     * @ORM\ManyToOne(targetEntity="Playbloom\Trainer\AppBundle\Entity\Session")
     * @Assert\NotNull()
     * @Assert\Type("Playbloom\Trainer\AppBundle\Entity\Session")
     */
    private $session;

    /**
     * @var Feedback
     *
     * @ORM\OneToMany(targetEntity="Playbloom\Trainer\AppBundle\Entity\Feedback", mappedBy="report")
     * @Assert\NotNull()
     * @Assert\Type("Playbloom\Trainer\AppBundle\Entity\Feedback")
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
    public function setSession(Session $session)
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

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'date' => $this->date,
            'feedbacks' => $this->feedbacks
        ];
    }
}