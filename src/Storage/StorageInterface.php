<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

interface StorageInterface
{
    /**
     * @param MetricInterface $metric
     * @throws StorageException
     */
    public function store(MetricInterface $metric);
}
