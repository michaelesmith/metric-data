<?php

namespace MS\EventData;

use MS\EventData\Event\EventInterface;
use MS\EventData\Logger\LoggerInterface;
use MS\EventData\Storage\StorageInterface;

/**
 *
 * @version 0.1
 *
 * @author msmith
 */
class EventDataManager
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var bool
     */
    protected $delayed = false;

    /**
     * @var LoggerInterface[]
     */
    protected $loggers = [];

    /**
     * @var EventInterface[]
     */
    protected $events = [];

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function addLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;
    }

    /**
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $delayed
     */
    public function setDelayed($delayed)
    {
        $this->delayed = $delayed;
    }

    /**
     * @return boolean
     */
    public function getDelayed()
    {
        return $this->delayed;
    }

    /**
     * @param EventInterface $event
     */
    public function store(EventInterface $event)
    {
        $this->events[] = $event;

        if (!$this->delayed) {
            $this->flush();
        }
    }

    /**
     *
     */
    public function flush()
    {
        foreach ($this->events as $event) {
            $this->flushEvent($event);
        }

        $this->events = [];
    }

    protected function flushEvent(EventInterface $event)
    {
        $result = null;
        if (!$this->debug) {
            $result = $this->storage->store($event);
        }

        foreach ($this->loggers as $logger) {
            $logger->log($event, $result);
        }
    }
}
