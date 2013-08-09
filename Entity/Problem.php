<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use SensioLabs\Bundle\MaydayBundle\Form\ProblemDTO;
use SensioLabs\Connect\Api\Api;
use SensioLabs\Connect\Api\Entity\User;

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
     * @ORM\Column(type="string", name="user_uuid")
     */
    private $userUuid;

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
    private $notifications = array();

    /**
     * @var Genius|null
     *
     * @ORM\ManyToOne(targetEntity="Genius")
     * @ORM\JoinColumn(name="genius_uuid", referencedColumnName="uuid")
     */
    private $agent;

    /**
     * @param ProblemDTO $dto
     */
    public function __construct(ProblemDTO $dto)
    {
        $this->update($dto);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Genius $genius
     *
     * @return Problem
     */
    public function handle(Genius $genius)
    {
        $this->agent = $genius;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHandled()
    {
        return null !== $this->agent;
    }

    /**
     * Rewards a genius.
     *
     * @return Problem
     */
    public function reward()
    {
    	return new Kiss($this->agent, $this->description);
    }

    /**
     * @param ProblemDTO $dto
     */
    public function update(ProblemDTO $dto)
    {
        $this->userUuid = $dto->user->get('uuid');
        $this->description = $dto->description;
        $this->priority = $dto->priority;
    }

    /**
     * Returns problem DTO.
     */
    public function getDTO(Api $api)
    {
        $dto = new ProblemDTO();
        $dto->priority = $this->priority;
        $dto->description = $this->description;
        $dto->user = $api->getRoot()->getUser($this->userUuid);

        return $dto;
    }

    /**
     * Returns problem DTO.
     */
    public function getAgent(Api $api)
    {
        return $this->agent ? $api->getRoot()->getUser($this->agent->getUuid()) : null;
    }

    public function isAdmin(User $user)
    {
        return $user->get('uuid') === $this->userUuid;
    }
}
