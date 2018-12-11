<?php

namespace MetricData\Metric;

interface FloatMetricInterface extends MetricInterface
{
    /**
     * @return float
     */
    public function getData(): float;
}
