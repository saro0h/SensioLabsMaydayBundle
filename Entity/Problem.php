<?php

namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SensioLabs\Bundle\MaydayBundle\Form\ProblemDTO;
use SensioLabs\Connect\Api\Api;

/**
 * Represent a problem to resolve.
 *
 * @author Sarah Khalil <sarah.khalil@sensiolabs.com>
 *
 * @ORM\Table(name="mayday_problem")
 * @ORM\Entity(repositoryClass="SensioLabs\Bundle\MaydayBundle\Repository\ProblemRepository")
 */
class Problem
{
    const STATUS_NEW      = 'new';
    const STATUS_HANDLED  = 'handled';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CANCELED = 'canceled';

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
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="agent_uuid", referencedColumnName="uuid")
     */
    private $agent;

    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="resolver_uuid", referencedColumnName="uuid")
     */
    private $resolver;

    /**
     * @param User       $owner
     * @param ProblemDTO $dto
     */
    public function __construct(User $owner, ProblemDTO $dto)
    {
        $this->owner = $owner;
        $this->update($dto);
    }

    /**
     * @param ProblemDTO $dto
     */
    public function update(ProblemDTO $dto)
    {
        $this->description = $dto->description;
        $this->priority = $dto->priority;
    }

    /**
     * Problem handled by given user.
     *
     * @param User $agent
     *
     * @return Problem
     *
     * @throws \LogicException
     */
    public function handle(User $agent)
    {
        if (null !== $this->agent) {
            throw new \LogicException(sprintf('This problem is already handled by "%s"".', $this->agent));
        }

        $this->agent = $agent;

        return $this;
    }

    /**
     * Problem solved by given user.
     *
     * @param User $resolver
     *
     * @return Problem
     *
     * @throws \LogicException
     */
    public function resolve(User $resolver)
    {
        if (null !== $this->resolver) {
            throw new \LogicException(sprintf('This problem is already resolved by "%s"".', $this->resolver));
        }

        $this->resolver = $resolver;

        return $this;
    }

    /**
     * Problem canceled by its owner.
     *
     * @return Problem
     */
    public function cancel()
    {
        return $this->resolve($this->owner);
    }

    /**
     * Returns problem status.
     *
     * @return string
     */
    public function getStatus()
    {
        if (null !== $this->resolver) {
            return self::STATUS_RESOLVED;
        }

        if (null !== $this->agent) {
            return self::STATUS_HANDLED;
        }

        if ($this->resolver === $this->owner) {
            return self::STATUS_CANCELED;
        }

        return self::STATUS_NEW;
    }

    /**
     * Returns problem as an array.
     *
     * @return array
     */
    public function asArray()
    {
        return array(
            'id'          => $this->id,
            'description' => $this->description,
            'priority'    => $this->priority,
            'status'      => $this->getStatus(),
            'owner'       => $this->owner->asArray(),
            'agent'       => $this->agent ? $this->agent->asArray() : null,
            'resolver'    => $this->resolver ? $this->resolver->asArray() : null,
        );
    }
}
