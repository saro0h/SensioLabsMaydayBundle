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
     * @ORM\JoinColumn(name="genius_uuid", referencedColumnName="uuid")
     */
    private $genius;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @param Genius $genius
     */
    public function __construct(Genius $genius)
    {
        $this->genius = $genius->kiss($this);
        $this->date = new \DateTime();
    }
}
