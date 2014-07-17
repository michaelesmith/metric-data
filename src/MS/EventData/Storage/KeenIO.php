<?php

namespace MS\EventData\Storage;

use KeenIO\Client\KeenIOClient;
use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\Result;

class KeenIO implements StorageInterface, StorageConfigurationInterface {

    /**
     * @var \KeenIO\Client\KeenIOClient
     */
    protected $client;

    public function __construct(KeenIOClient $client)
    {
        $this->client = $client;
    }

    public function getConfiguration()
    {
        return $this->client->getConfig()->toArray();
    }

    /**
     * @param EventInterface $event
     * @return \MS\EventData\Storage\Result\ResultInterface
     */
    public function store(EventInterface $event)
    {
        try {
            $result = $this->client->addEvent($event->getCollection(), $event->getPayload());
        } catch (\Exception $e) {
            return new Result($e->getMessage(), true);
        }

        return new Result($result, false);
    }

} 
