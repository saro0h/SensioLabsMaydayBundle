<?php

namespace SensioLabs\Bundle\MaydayBundle\Notifier;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Notification
{
    /**
     * @var string
     */
    private $event;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param string $event
     * @param array  $parameters
     */
    public function __construct($event, array $parameters = array())
    {
        $this->event = $event;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
