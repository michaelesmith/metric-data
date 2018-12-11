<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

class ClosureStorage implements StorageInterface
{
    /**
     * @var \Closure
     */
    private $closure;

    /**
     * @param \Closure $closure
     */
    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $closure = $this->closure;
        $closure($metric);
    }
}
