<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Colections\ArrayCollection;

/**
 * Represent a guy who resolves the request.
 *
 * @author Sarah Khalil <sarah.khalil@sensiolabs.com>
 *
 * @ORM\Table(name="mayday_genius")
 * @ORM\Entity()
 */
class Genius
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var ArrayCollection 
     *
     * @ORM\OneToMany(targetEntity="Kiss", mappedBy="genius")
     */
    private $kisses;

    public function __construct()
    {
    	$this->kisses = new ArrayCollection();
    }

    /**
     * Kisses genius.
     * 
     * @param Kiss $kiss
     *
     * @return Genius
     */
    public function kiss(Kiss $kiss)
    {
    	if (!in_array($kiss, $kisses, true)) {
    		$this->kisses[] = $kiss;
    	}

    	return $this;
    }
}
