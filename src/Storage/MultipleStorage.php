<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

class MultipleStorage implements StorageInterface
{
    /**
     * @var StorageInterface[]
     */
    private $storages;

    /**
     * @var bool
     */
    private $locked = false;

    /**
     * @param StorageInterface[] $storeages
     */
    public function __construct(array $storeages = [])
    {
        $this->storages = $storeages;
    }

    /**
     * @param StorageInterface $storage
     * @throws \InvalidArgumentException
     */
    public function addStorage(StorageInterface $storage)
    {
        if ($this->locked) {
            throw new \InvalidArgumentException('You can not add a storage after a metric has been stored which could cause unexpected results');
        }

        $this->storages[] = $storage;
    }

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $this->locked = true;

        foreach ($this->storages as $storage) {
            $storage->store($metric);
        }
    }
}
