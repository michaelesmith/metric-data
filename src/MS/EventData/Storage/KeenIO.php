<?php

namespace MS\EventData\Storage;

use KeenIO\Client\KeenIOClient;
use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\Result;

class KeenIO implements StorageInterface {

    /**
     * @var \KeenIO\Client\KeenIOClient
     */
    protected $client;

    public function __construct(KeenIOClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param EventInterface $event
     * @return \MS\EventData\Storage\Result\ResultInterface
     */
    public function store(EventInterface $event)
    {
        $result = $this->client->addEvent($event->getCollection(), $event->getPayload());

        return new Result($result, false);
    }

} 
