<?php

namespace MS\EventData\Logger;

use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\ResultInterface;

class GenericLoggedEvent {

    /**
     * @var \MS\EventData\Event\EventInterface
     */
    public $event;

    /**
     * @var \MS\EventData\Storage\Result\ResultInterface
     */
    public $result;

    public function __construct(EventInterface $event, ResultInterface $result = null)
    {
        $this->event = $event;
        $this->result = $result;
    }

} 
