<?php

namespace SensioLabs\Bundle\MaydayBundle\Notifier;

use SensioLabs\Bundle\MaydayBundle\React\Server;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ReactNotifier implements NotifierInterface
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function notify(Notification $notification)
    {
        $this->server->broadcast($notification->getEvent(), $notification->getParameters());
    }
}
