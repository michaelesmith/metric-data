<?php

namespace MS\EventData\Storage;

use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\Result;

class File implements StorageInterface {

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param EventInterface $event
     * @return \MS\EventData\Storage\Result\ResultInterface
     */
    public function store(EventInterface $event)
    {
        file_put_contents($this->filename, sprintf("%s: %s - %s\n", date('y-m-d H:i:s'), $event->getCollection(), json_encode($event->getPayload())), FILE_APPEND);

        return new Result(true);
    }

} 
