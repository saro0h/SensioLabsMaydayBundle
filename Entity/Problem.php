<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Colections\ArrayCollection;

/**
 * Represent a problem to resolve.
 *
 * @author Sarah Khalil <sarah.khalil@sensiolabs.com>
 *
 * @ORM\Table(name="mayday_problem")
 * @ORM\Entity()
 */
class Problem 
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    private $notifications;

    /**
     * @var ArrayCollection 
     *
     * @ORM\OneToMany(targetEntity="Kiss", mappedBy="problem")
     */
    private $kisses;

    public function __construct()
    {
    	$this->kisses = new ArrayCollection();
    }

    /**
     * Rewards a genius.
     * 
     * @param Genius $genius
     *
     * @return Problem
     */
    public function reward(Genius $genius)
    {
    	$kiss = new Kiss($genius, $this);
    	$this->kisses[] = $kiss;

    	return $this;
    }
}
