<?php

namespace MetricData\Tests\Unit;

use MetricData\Metric\Metric;
use MetricData\Tests\Common\TestCase;

class StorageTestCase extends TestCase
{
    protected function getMetric($data = 1, $type = 'TestType', $date = null): Metric
    {
        $date = $date ?: new \DateTime();

        return new Metric($date, $type, $data);
    }
}
