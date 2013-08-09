<?php

namespace SensioLabs\Bundle\MaydayBundle\Form;

use SensioLabs\Connect\Api\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class ProblemDTO
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    public $description;

    /**
     * @var integer
     *
     * @Assert\NotNull
     */
    public $priority;
}
