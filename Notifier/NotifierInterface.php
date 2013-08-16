<?php

namespace SensioLabs\Bundle\MaydayBundle\Notifier;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface NotifierInterface
{
    /**
     * Notifies users.
     *
     * @param Notification $notification
     */
    public function notify(Notification $notification);
}
