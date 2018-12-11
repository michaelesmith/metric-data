<?php

namespace MetricData\Tests\Unit;

use KeenIO\Client\KeenIOClient;
use KeenIO\Exception\RuntimeException;
use MetricData\Metric\ArrayMetric;
use MetricData\Metric\Metric;
use MetricData\Storage\KeenIOStorage;
use MetricData\Storage\StorageException;

class KeenIOStorageTest extends StorageTestCase
{
    const TYPE = 'type';
    const DATA = 1;

    public function dpTestStore()
    {
        return [
            0 => [
                new Metric($dt = new \DateTime(), self::TYPE, self::DATA), // $metric
                ['data' => self::DATA, 'ts' => $dt->format('r')], // $event
            ],
            1 => [
                new ArrayMetric($dt = new \DateTime(), self::TYPE, $arr = ['field1' => self::DATA, 'field2' => 2, 'ts' => $dt->format('r')]), // $metric
                $arr, // $event
            ],
            2 => [
                new Metric($dt = new \DateTime(), self::TYPE, self::DATA), // $metric
                ['data' => self::DATA, 'ts' => $dt->format('r')], // $event
                RuntimeException::class, // $exceptionClass
            ],
        ];
    }

    /**
     * @dataProvider dpTestStore
     */
    public function testStore($metric, $event, $exceptionClass = null)
    {
        $keenIO = \Mockery::mock(KeenIOClient::class);
        $addEvent = $keenIO->expects('addEvent')->once()->with(self::TYPE, $event);
        if ($exceptionClass) {
            $addEvent->andThrow($exceptionClass);
            $this->expectException(StorageException::class);
        }

        $sut = new KeenIOStorage($keenIO);
        $sut->store($metric);
    }
}
