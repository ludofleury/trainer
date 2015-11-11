<?php

namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $reps;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $sets;

    /**
     * @var int The number of seconds
     *
     * @ORM\Column(type="smallint")
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