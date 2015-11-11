<?php

namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * @ORM\Entity;
 */
class Exercise implements JsonSerializable
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
     * @var Session
     * @ORM\ManyToOne(targetEntity="Playbloom\Trainer\AppBundle\Entity\Session", inversedBy="exercises")
     */
    private $session;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 4,
     *      max = 255,
     *      minMessage= "The name must be at least 4 characters long",
     *      maxMessage= "The name can't be longer than 255 characters"
     * )
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 100,
     *      minMessage = "The reps should be at least 1"
     *      maxMessage = "The reps can't be greater than 100"
     * )
     */
    private $reps;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 10,
     *      minMessage = "The sets should be at least 1"
     *      maxMessage = "The sets can't be greater than 10"
     * )
     */
    private $sets;

    /**
     * @var int The number of seconds
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 300,
     *      minMessage = "The rest should be at least 00"
     *      maxMessage = "The rest can't be greater than 300    "
     * )
     */
    private $rest;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getReps()
    {
        return $this->reps;
    }

    /**
     * @param int $reps
     */
    public function setReps($reps)
    {
        $this->reps = $reps;
    }

    /**
     * @return int
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * @param int $sets
     */
    public function setSets($sets)
    {
        $this->sets = $sets;
    }

    /**
     * @return int
     */
    public function getRest()
    {
        return $this->rest;
    }

    /**
     * @param int $rest
     */
    public function setRest($rest)
    {
        $this->rest = $rest;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
            'name' => $this->name,
            'reps' => $this->reps,
            'sets' => $this->sets,
            'rest' => $this->rest,
            'description' => $this->description
        ];
    }
}