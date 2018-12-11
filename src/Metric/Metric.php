<?php

namespace MetricData\Metric;

class Metric implements MetricInterface
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @param \DateTime $dateTime
     * @param string $type
     * @param mixed $data
     */
    public function __construct(\DateTime $dateTime, string $type, $data)
    {
        $this->dateTime = $dateTime;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
