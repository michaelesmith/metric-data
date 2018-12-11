<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

class MemoryStorage implements StorageInterface
{
    /**
     * @var MetricInterface[]
     */
    private $metrics = [];

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $this->metrics[] = $metric;
    }

    /**
     * @return MetricInterface[]
     */
    public function getMetrics(): array
    {
        return $this->metrics;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->metrics);
    }

    /**
     * @return MetricInterface|null
     */
    public function first(): ?MetricInterface
    {
        return isset($this->metrics[0]) ? $this->metrics[0] : null;
    }

    /**
     * @return MetricInterface|null
     */
    public function last(): ?MetricInterface
    {
        return isset($this->metrics[0]) ? $this->metrics[$this->count() - 1] : null;
    }
}
