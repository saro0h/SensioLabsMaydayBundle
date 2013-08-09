<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use SensioLabs\Connect\Api\Api;

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
    private $uuid;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Kiss", mappedBy="genius")
     */
    private $kisses;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    	$this->kisses = new ArrayCollection();
    }

    public function getUuid()
    {
        return $this->uuid;
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
    	if (!$this->kisses->contains($kiss)) {
    		$this->kisses->add($kiss);
    	}

    	return $this;
    }
}
