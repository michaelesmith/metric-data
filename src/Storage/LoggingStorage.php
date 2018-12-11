<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;
use Psr\Log\LoggerInterface;

class LoggingStorage implements StorageInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $level;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @param LoggerInterface $logger
     * @param string $level
     * @param StorageInterface $storage
     */
    public function __construct(LoggerInterface $logger, string $level, StorageInterface $storage)
    {
        $this->logger = $logger;
        $this->level = $level;
        $this->storage = $storage;
    }

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $this->logger->log($this->level, sprintf(
            '%s: MetricData %s - %s',
            $metric->getDateTime()->format('r'),
            $metric->getType(),
            var_export($metric->getData(), true)
        ));

        $this->storage->store($metric);
    }
}
