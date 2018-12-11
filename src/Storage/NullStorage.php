<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

class NullStorage implements StorageInterface
{
    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {

    }
}
