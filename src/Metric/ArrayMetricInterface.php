<?php

namespace MetricData\Metric;

interface ArrayMetricInterface extends MetricInterface
{
    /**
     * @return array
     */
    public function getData(): array;
}
