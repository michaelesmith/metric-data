<?php

namespace MS\EventData\Logger;

use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\ResultInterface;

class GenericLogger implements LoggerInterface {

    /**
     * @var GenericLoggedEvent[]
     */
    protected $events = [];

    public function log(EventInterface $event, ResultInterface $result = null)
    {
        $this->events[] = new GenericLoggedEvent($event, $result);
    }

    /**
     * @return \MS\EventData\Logger\GenericLoggedEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }

} 
