<?php

namespace MetricData\Metric;

class ArrayMetric extends Metric implements ArrayMetricInterface
{
    /**
     * @param \DateTime $dateTime
     * @param string $type
     * @param array $data
     */
    public function __construct(\DateTime $dateTime, string $type, array $data)
    {
        parent::__construct($dateTime, $type, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return parent::getData();
    }
}
