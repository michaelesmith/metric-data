<?php

namespace MetricData\Storage;

use KeenIO\Client\KeenIOClient;
use KeenIO\Exception\RuntimeException;
use MetricData\Metric\ArrayMetricInterface;
use MetricData\Metric\MetricInterface;

class KeenIOStorage implements StorageInterface
{
    /**
     * @var KeenIOClient
     */
    private $keenIO;

    /**
     * @param KeenIOClient $keenIO
     */
    public function __construct(KeenIOClient $keenIO)
    {
        $this->keenIO = $keenIO;
    }

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $event = $metric instanceof ArrayMetricInterface ? $metric->getData() : ['data' => $metric->getData()];
        $event['ts'] = $metric->getDateTime()->format('r');
        try {
            $this->keenIO->addEvent($metric->getType(), $event);
        } catch (RuntimeException $e) {
            throw new StorageException('An exception was thrown by the Keen IO client', 0, $e);
        }
    }
}
