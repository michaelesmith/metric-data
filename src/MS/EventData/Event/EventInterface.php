<?php

namespace MS\EventData\Event;

interface EventInterface {

    public function getCollection();

    public function getPayload();

} 
