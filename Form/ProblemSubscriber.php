<?php

namespace SensioLabs\Bundle\MaydayBundle\Form;

use SensioLabs\Connect\Security\Authentication\Token\ConnectToken;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class ProblemSubscriber implements EventSubscriberInterface
{
    /**
     * @var SecurityContext
     */
    private $context;

    /**
     * @param SecurityContext $context
     */
    public function __construct(SecurityContext $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SUBMIT => 'postSubmit');
    }

    /**
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event)
    {
        $token = $this->context->getToken();

        if ($token instanceof ConnectToken) {
            $data = $event->getData() ?: new ProblemDTO();
            $data->user = $token->getApiUser();
            $event->setData($data);
        };
    }
}
