<?php


namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity()
 */
class Program implements JsonSerializable
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
     * @var int The month number
     *
     * @ORM\Column(type="smallint")
     */
    private $month;

    /**
     * @var Session[]
     *
     * @ORM\OneToMany(targetEntity="Playbloom\Trainer\AppBundle\Entity\Session", mappedBy="program")
     */
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return Session[]
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @param Session $session
     */
    public function addSession(Session $session)
    {
        $session->setProgram($this);
        $this->sessions->add($session);
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
        return  [
            'month' => $this->month,
            'sessions' => $this->sessions->toArray()
        ];
    }


}