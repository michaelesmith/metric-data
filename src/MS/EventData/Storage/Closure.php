<?php

namespace MS\EventData\Storage;

use MS\EventData\Event\EventInterface;
use MS\EventData\Storage\Result\ResultInterface;

class Closure implements StorageInterface {

    /**
     * @var \Closure
     */
    protected $closure;

    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @throws \RuntimeException if closure does not return \MS\EventData\Storage\Result\ResultInterface
     *
     * @param EventInterface $event
     * @return \MS\EventData\Storage\Result\ResultInterface
     */
    public function store(EventInterface $event)
    {
        $result = call_user_func($this->closure, array($event));

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(sprintf('Closure must return instance of MS\EventData\Storage\Result\ResultInterface "%s" given', get_class($result)));
        }

        return $result;
    }

} 
