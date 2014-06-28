<?php

namespace MS\EventData\Logger;

use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\ResultInterface;

interface LoggerInterface {

    public function log(EventInterface $event, ResultInterface $result = null);

} 
