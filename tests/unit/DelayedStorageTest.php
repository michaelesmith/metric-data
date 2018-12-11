<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\DelayedStorage;
use MetricData\Storage\StorageInterface;

class DelayedStorageTest extends StorageTestCase
{
    public function testStore()
    {
        $storage = \Mockery::mock(StorageInterface::class);

        $metric1 = $this->getMetric(1);
        $metric2 = $this->getMetric(2);
        $metric3 = $this->getMetric(3);

        $sut = new DelayedStorage($storage);
        $sut->flush(); // should not cause an exception since we don't have any metrics yet
        $sut->store($metric1);
        $sut->store($metric2);

        $storage->expects('store')->once()->with($metric1);
        $storage->expects('store')->once()->with($metric2);

        $sut->flush();
        $sut->flush(); // should not restore metrics

        $sut->store($metric3);

        $storage->expects('store')->once()->with($metric3);

        $sut->flush();
    }
}
