<?php

namespace MetricData\Metric;

class FloatMetric extends Metric implements FloatMetricInterface
{
    /**
     * @param \DateTime $dateTime
     * @param string $type
     * @param float $data
     */
    public function __construct(\DateTime $dateTime, string $type, float $data)
    {
        parent::__construct($dateTime, $type, $data);
    }

    /**
     * @return int
     */
    public function getData(): float
    {
        return parent::getData();
    }
}
