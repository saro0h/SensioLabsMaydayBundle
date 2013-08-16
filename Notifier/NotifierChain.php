<?php

namespace SensioLabs\Bundle\MaydayBundle\Notifier;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class NotifierChain implements NotifierInterface
{
    /**
     * @var NotifierInterface[]
     */
    private $notifiers = array();

    /**
     * Registers a notifier.
     *
     * @param NotifierInterface $notifier
     */
    public function register(NotifierInterface $notifier)
    {
        $this->notifiers[] = $notifier;
    }

    /**
     * {@inheritdoc}
     */
    public function notify(Notification $notification)
    {
        foreach ($this->notifiers as $notifier) {
            $notifier->notify($notification);
        }
    }
}
