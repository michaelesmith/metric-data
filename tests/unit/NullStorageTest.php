<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\NullStorage;

class NullStorageTest extends StorageTestCase
{
    public function testStore()
    {
        $sut = new NullStorage();

        // not much to test here other than we don't get an exception
        $this->assertNull($sut->store($this->getMetric()));
    }
}
