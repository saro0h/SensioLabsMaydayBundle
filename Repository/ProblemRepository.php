<?php
namespace SensioLabs\Bundle\MaydayBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SensioLabs\Bundle\MaydayBundle\Entity\Problem;

class ProblemRepository extends EntityRepository
{
    /**
     * List unresolved problems.
     *
     * @return Problem[]
     */
    public function listActiveOnes()
    {
        return $this
            ->createQueryBuilder('p')
            ->innerJoin('p.owner', 'o')
            ->leftJoin('o.kisses', 'ok')
            ->leftJoin('p.agent', 'a')
            ->leftJoin('a.kisses', 'ak')
            ->where('p.resolver is null')
            ->orderBy('p.priority', 'desc')
            ->orderBy('p.createdAt', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * List resolved problems.
     *
     * @return Problem[]
     */
    public function listArchivedOnes()
    {
        return $this
            ->createQueryBuilder('p')
            ->innerJoin('p.owner', 'o')
            ->leftJoin('p.resolver', 'r')
            ->where('p.resolver is not null')
            ->orderBy('p.createdAt', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * Saves a problem in the repository.
     *
     * @param Problem $problem
     *
     * @return ProblemRepository
     */
    public function save(Problem $problem)
    {
        $this->_em->persist($problem);
        $this->_em->flush();

        return $this;
    }
}
