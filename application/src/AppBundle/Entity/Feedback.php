<?php


namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;

/**
 * @ORM\Entity()
 */
class Feedback implements JsonSerializable
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
     * @var Report
     *
     * @ORM\ManyToOne(targetEntity="Playbloom\Trainer\AppBundle\Entity\Report", inversedBy="feedbacks")
     * @Assert\NotNull()
     * @Assert\Type("Playbloom\Trainer\AppBundle\Entity\Report")
     */
    private $report;

    /**
     * @var Exercise
     *
     * @ORM\OneToOne(targetEntity="Playbloom\Trainer\AppBundle\Entity\Exercise")
     * @Assert\NotNull()
     * @Assert\Type("Playbloom\Trainer\AppBundle\Entity\Exercise")
     */
    private $exercise;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", name="setNumber")
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 100,
     *      minMessage = "The set should be at least 1",
     *      maxMessage = "The set can't be greater than 100"
     * )
     */
    private $set;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 500,
     *      minMessage = "The reps should be at least 1",
     *      maxMessage = "The reps can't be greater than 500"
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
     *      max = 500,
     *      minMessage = "The weight should be at least 1",
     *      maxMessage = "The weight can't be greater than 500"
     * )
     */
    private $weight;

    /**
     * @var int 3 => easy, 2 => normal, 1 => hard
     *
     * @ORM\Column(type="smallint")
     */
    private $feeling;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $comment;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Report
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param Report $report
     */
    public function setReport(Report $report)
    {
        $this->report = $report;
    }

    /**
     * @return Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     */
    public function setExercise($exercise)
    {
        $this->exercise = $exercise;
    }

    /**
     * @return int
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @param int $set
     */
    public function setSet($set)
    {
        $this->set = $set;
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
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getFeeling()
    {
        return $this->feeling;
    }

    /**
     * @param int $feeling
     */
    public function setFeeling($feeling)
    {
        $this->feeling = $feeling;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
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
            'exercise' => $this->exercise,
            'set' => $this->set,
            'reps' => $this->reps,
            'weight' => $this->weight,
            'feeling' => $this->feeling,
            'comment' => $this->comment
        ];
    }
}