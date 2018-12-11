<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

class DelayedStorage implements StorageInterface
{
    /**
     * @var MetricInterface[]
     */
    private $metrics = [];

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $this->metrics[] = $metric;
    }

    /**
     * @throws StorageException
     */
    public function flush()
    {
        foreach ($this->metrics as $metric) {
            $this->storage->store($metric);
        }

        $this->metrics = [];
    }
}
