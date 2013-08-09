<?php

namespace SensioLabs\Bundle\MaydayBundle\Service;

use SensioLabs\Bundle\MaydayBundle\Model\Problem;

interface ProblemRepositoryInterface 
{
    /**
     * Lists problems.
     * 
     * @return Problem[]
     */
    public function list();

    /**
     * Finds a problem by its id.
     * 
     * @return Problem[]
     *
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     * Saves a problem.
     * 
     * @param Problem $problem
     */
    public function save(Problem $problem);
}
