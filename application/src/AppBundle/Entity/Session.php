<?php


namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * @ORM\Entity()
 */
class Session implements JsonSerializable
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
     * @var Program
     *
     * @ORM\ManyToOne(targetEntity="Playbloom\Trainer\AppBundle\Entity\Program", inversedBy="sessions")
     * @Assert\NotNull()
     * @Assert\Type("Playbloom\Trainer\AppBundle\Entity\Program")
     */
    private $program;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 7,
     *      minMessage = "The day should be at least 1",
     *      maxMessage = "The day can't be greater than 7"
     * )
     */
    private $day;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Playbloom\Trainer\AppBundle\Entity\Exercise")
     */
    private $exercises;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param Program $program
     */
    public function setProgram($program)
    {
        $this->program = $program;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return array
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * @param array $exercises
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
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
            'day' => $this->day,
            'exercise' => $this->exercises->toArray()
        ];
    }


}