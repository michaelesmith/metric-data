<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\MultipleStorage;
use MetricData\Storage\StorageInterface;

class MultipleStorageTest extends StorageTestCase
{
    public function testStore()
    {
        $metric = $this->getMetric();

        $storage1 = \Mockery::mock(StorageInterface::class);
        $storage1->shouldReceive('store')->once()->with($metric);

        $storage2 = \Mockery::mock(StorageInterface::class);
        $storage2->shouldReceive('store')->once()->with($metric);

        $sut = new MultipleStorage([$storage1, $storage2]);
        $sut->store($metric);
    }

    public function testStorageLocking()
    {
        $metric = $this->getMetric();

        $storage1 = \Mockery::mock(StorageInterface::class);
        $storage1->shouldReceive('store')->once()->with($metric);

        $storage2 = \Mockery::mock(StorageInterface::class);
        $storage2->shouldReceive('store')->never();

        $sut = new MultipleStorage([]);
        $sut->addStorage($storage1);
        $sut->store($metric);

        $this->expectException(\InvalidArgumentException::class);
        $sut->addStorage($storage2);
    }
}
