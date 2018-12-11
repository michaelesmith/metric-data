<?php

namespace MetricData\Tests\Unit;

use MetricData\Storage\LoggingStorage;
use MetricData\Storage\StorageInterface;
use Psr\Log\LoggerInterface;

class LoggingStorageTest extends StorageTestCase
{
    const LEVEL = 300;

    public function testStore()
    {
        $metric = $this->getMetric('TestData', 'TestType', new \DateTime('1980-02-05 06:45'));

        $logger = \Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->once()->with(self::LEVEL, 'Tue, 05 Feb 1980 06:45:00 +0000: MetricData TestType - \'TestData\'');

        $storage = \Mockery::mock(StorageInterface::class);
        $storage->expects('store')->once()->with($metric);

        $sut = new LoggingStorage($logger, self::LEVEL, $storage);
        $sut->store($metric);
    }
}
