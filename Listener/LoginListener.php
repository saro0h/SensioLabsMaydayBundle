<?php

namespace SensioLabs\Bundle\MaydayBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SensioLabs\Bundle\MaydayBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Login listener.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class LoginListener
{
    /**
     * @var SecurityContextInterface
     */
    private $context;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @param SecurityContextInterface $context
     * @param Registry                 $doctrine
     */
    public function __construct(SecurityContextInterface $context, Registry $doctrine)
    {
        $this->context = $context;
        $this->repository = $doctrine->getRepository('SensioLabsMaydayBundle:User');
    }

    /**
     * Triggered on user login.
     *
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($this->context->isGranted('ROLE_CONNECT_USER')) {
            $this->repository->register($event->getAuthenticationToken()->getApiUser());
        }
    }
}
