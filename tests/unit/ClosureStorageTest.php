<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\ClosureStorage;

class ClosureStorageTest extends StorageTestCase
{
    public function testStore()
    {
        $expectedMetric = $this->getMetric();

        $closure = function($metric) use ($expectedMetric) {
            $this->assertEquals($expectedMetric, $metric);
        };

        $sut = new ClosureStorage($closure);
        $sut->store($expectedMetric);
    }
}
