<?php


namespace Playbloom\Trainer\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Feedback
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
    public function setReport($report)
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
}