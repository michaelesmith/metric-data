<?php

namespace MetricData\Metric;

interface IntegerMetricInterface extends MetricInterface
{
    /**
     * @return int
     */
    public function getData(): int;
}
