<?php

namespace MS\EventData\Storage;

use MS\EventData\Event\EventInterface;

interface StorageInterface {

    /**
     * @param EventInterface $event
     * @return \MS\EventData\Storage\Result\ResultInterface
     */
    public function store(EventInterface $event);

} 
