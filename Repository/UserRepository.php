<?php

namespace SensioLabs\Bundle\MaydayBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SensioLabs\Bundle\MaydayBundle\Entity\User;
use SensioLabs\Connect\Api\Entity\User as ConnectUser;

/**
 * User repository.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class UserRepository extends EntityRepository
{
    /**
     * Registers a connect user in user repository.
     *
     * @param ConnectUser $connectUser
     */
    public function register(ConnectUser $connectUser)
    {
        $user = $this->find($connectUser->get('uuid'));

        if (null === $user) {
            $user = new User($user);
            $this->_em->persist($user);
        }

        $user->update($connectUser);
        $this->_em->flush();
    }
}
