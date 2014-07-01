<?php

namespace MS\EventData\Logger;

use MS\EventData\Event\EventInterface;
use MS\EventData\EventDataManager;
use MS\EventData\Storage\Result\ResultInterface;
use Psr\Log\LoggerInterface as PSRLoggerInterface;

class PSRLogger implements LoggerInterface {

    protected $logger;

    protected $eventManager;

    public function __construct(PSRLoggerInterface $logger, EventDataManager $manager)
    {
        $this->logger = $logger;
        $this->eventManager = $manager;
    }

    public function log(EventInterface $event, ResultInterface $result = null)
    {
        $this->logger->info(
            sprintf(
                'Event Manager: debug %s delayed %s ',
                $this->eventManager->getDebug() ? 'on' : 'off',
                $this->eventManager->getDelayed() ? 'on' : 'off'
            )
            .
            json_encode(array(
                'collection' => $event->getCollection(),
                'payload' => $event->getPayload(),
                'result' => $result ? $result->getData() : null,
                'error' => $result ? $result->hasError() : null,
            ))
        );
    }

}
