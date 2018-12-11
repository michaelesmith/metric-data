<?php

namespace MetricData\Metric;

class IntegerMetric extends Metric implements IntegerMetricInterface
{
    /**
     * @param \DateTime $dateTime
     * @param string $type
     * @param int $data
     */
    public function __construct(\DateTime $dateTime, string $type, int $data)
    {
        parent::__construct($dateTime, $type, $data);
    }

    /**
     * @return int
     */
    public function getData(): int
    {
        return parent::getData();
    }
}
