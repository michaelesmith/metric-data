<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\MemoryStorage;

class MemoryStorageTest extends StorageTestCase
{
    public function testGetMetrics()
    {
        $metric1 = $this->getMetric(1);
        $metric2 = $this->getMetric(2);
        $metric3 = $this->getMetric(3);

        $sut = new MemoryStorage();
        $this->assertEquals([], $sut->getMetrics());

        $sut->store($metric1);
        $this->assertEquals([$metric1], $sut->getMetrics());

        $sut->store($metric2);
        $this->assertEquals([$metric1, $metric2], $sut->getMetrics());

        $sut->store($metric3);
        $this->assertEquals([$metric1, $metric2, $metric3], $sut->getMetrics());
    }

    public function testCount()
    {
        $metric1 = $this->getMetric(1);
        $metric2 = $this->getMetric(2);
        $metric3 = $this->getMetric(3);

        $sut = new MemoryStorage();
        $this->assertEquals(0, $sut->count());

        $sut->store($metric1);
        $this->assertEquals(1, $sut->count());

        $sut->store($metric2);
        $this->assertEquals(2, $sut->count());

        $sut->store($metric3);
        $this->assertEquals(3, $sut->count());
    }

    public function testFirst()
    {
        $metric1 = $this->getMetric(1);
        $metric2 = $this->getMetric(2);

        $sut = new MemoryStorage();
        $this->assertNull($sut->first());

        $sut->store($metric1);
        $this->assertEquals($metric1, $sut->first());

        $sut->store($metric2);
        $this->assertEquals($metric1, $sut->first());
    }

    public function testLast()
    {
        $metric1 = $this->getMetric(1);
        $metric2 = $this->getMetric(2);

        $sut = new MemoryStorage();
        $this->assertNull($sut->last());

        $sut->store($metric1);
        $this->assertEquals($metric1, $sut->last());

        $sut->store($metric2);
        $this->assertEquals($metric2, $sut->last());
    }
}
