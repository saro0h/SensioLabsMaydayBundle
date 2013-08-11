<?php
namespace SensioLabs\Bundle\MaydayBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProblemRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        return $this->getEntityManager()
        ->createQuery(
            'SELECT p FROM SensioLabsMaydayBundle:Problem p ORDER BY p.id DESC'
        )
        ->getResult();
    }
}