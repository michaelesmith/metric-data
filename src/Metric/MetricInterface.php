<?php

namespace MetricData\Metric;

interface MetricInterface
{
    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return mixed
     */
    public function getData();
}
