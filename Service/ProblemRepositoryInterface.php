<?php

namespace SensioLabs\Bundle\MaydayBundle\Service;

use SensioLabs\Bundle\MaydayBundle\Entity\Problem;

interface ProblemRepositoryInterface
{
    /**
     * Lists problems.
     *
     * @return Problem[]
     */
    public function all();

    /**
     * Finds a problem by its id.
     *
     * @param int $id
     *
     * @return Problem
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
