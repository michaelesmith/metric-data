<?php

namespace MS\EventData\Event;

class Event implements EventInterface {

    protected $collection;

    protected $payload;

    public function __construct($collection, $payload)
    {
        $this->collection = $collection;
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

}
