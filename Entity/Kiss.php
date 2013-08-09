<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represent a reward for having resolved a problem.
 *
 * @author Sarah Khalil <sarah.khalil@sensiolabs.com>
 *
 * @ORM\Table(name="mayday_kiss")
 * @ORM\Entity()
 */
class Kiss
{
    /**
     * @var Genius
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Genius", inversedBy="Kiss")
     * @ORM\JoinColumn(name="genius_username", referencedColumnName="username")
     */
    private $genius;

    /**
     * @var Problem
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Problem", inversedBy="Kiss")
     * @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     */
    private $problem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @param Genius  $genius
     * @param Problem $problem
     */
    public function __construct(Genius $genius, Problem $problem)
    {
        $this->genius = $genius;
        $this->problem = $problem;
        $this->date = new \DateTime();
    }
}
