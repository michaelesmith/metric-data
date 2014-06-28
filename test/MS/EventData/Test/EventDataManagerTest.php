<?php

namespace MS\EventData\Test;

use MS\EventData\EventDataManager;

class EventDataManagerTest extends TestCase
{

    public function testDefault()
    {
        $event = $this->getMock('\MS\EventData\Event\EventInterface');

        $result = $this->getMock('\MS\EventData\Storage\Result\ResultInterface');

        $storage = $this->getMock('\MS\EventData\Storage\StorageInterface');
        $storage->expects($this->once())
            ->method('store')
            ->with($event)
            ->will($this->returnValue($result))
        ;

        $logger = $this->getMock('\MS\EventData\Logger\LoggerInterface');
        $logger->expects($this->once())
            ->method('log')
            ->with($event, $result)
        ;

        $m = new EventDataManager($storage);
        $m->addLogger($logger);

        $m->store($event);
    }

    public function testDebug()
    {
        $event = $this->getMock('\MS\EventData\Event\EventInterface');

        $result = null;

        $storage = $this->getMock('\MS\EventData\Storage\StorageInterface');
        $storage->expects($this->never())
            ->method('store')
        ;

        $logger = $this->getMock('\MS\EventData\Logger\LoggerInterface');
        $logger->expects($this->once())
            ->method('log')
            ->with($event, $result)
        ;

        $m = new EventDataManager($storage);
        $m->addLogger($logger);
        $m->setDebug(true);

        $m->store($event);
    }

    public function testDelayedWithFlush()
    {
        $event = $this->getMock('\MS\EventData\Event\EventInterface');

        $result = $this->getMock('\MS\EventData\Storage\Result\ResultInterface');

        $storage = $this->getMock('\MS\EventData\Storage\StorageInterface');
        $storage->expects($this->once())
            ->method('store')
            ->with($event)
            ->will($this->returnValue($result))
        ;

        $logger = $this->getMock('\MS\EventData\Logger\LoggerInterface');
        $logger->expects($this->once())
            ->method('log')
            ->with($event, $result)
        ;

        $m = new EventDataManager($storage);
        $m->addLogger($logger);
        $m->setDelayed(true);

        $m->store($event);
        $m->flush();
    }

    public function testDelayed()
    {
        $event = $this->getMock('\MS\EventData\Event\EventInterface');

        $storage = $this->getMock('\MS\EventData\Storage\StorageInterface');
        $storage->expects($this->never())
            ->method('store')
        ;

        $logger = $this->getMock('\MS\EventData\Logger\LoggerInterface');
        $logger->expects($this->never())
            ->method('log')
        ;

        $m = new EventDataManager($storage);
        $m->addLogger($logger);
        $m->setDelayed(true);

        $m->store($event);
    }

}
