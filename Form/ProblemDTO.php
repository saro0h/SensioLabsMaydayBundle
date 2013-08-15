<?php

namespace SensioLabs\Bundle\MaydayBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class ProblemDTO
{
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
