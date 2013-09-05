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
     * @var User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="kisses")
     * @ORM\JoinColumn(name="user_uuid", referencedColumnName="uuid")
     */
    private $user;

    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Problem")
     * @ORM\JoinColumn(name="problem_id", referencedColumnName="id")
     */
    private $problem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @param User    $user
     * @param Problem $problem
     */
    public function __construct(User $user, Problem $problem)
    {
        $this->user = $user;
        $this->problem = $problem;
        $this->date = new \DateTime();
    }

    /**
     * Returns kiss as an array.
     *
     * Note that user is not returned as it could
     * lead to circular reference errors.
     *
     * @return array
     */
    public function asArray()
    {
        return array(
            'problem' => $this->problem->asArray(),
            'date'    => $this->date->format('Y-m-d H:i:s'),
        );
    }
}
