<?php

namespace MetricData\Storage;

use MetricData\Metric\MetricInterface;

class FileStorage implements StorageInterface
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var \SplFileObject
     */
    private $file;

    /**
     * @param string $filename
     * @throws \InvalidArgumentException
     */
    public function __construct(string $filename)
    {
        if (file_exists($filename) && !is_writable($filename)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" is not writable', $filename));
        } elseif (!is_writable(dirname($filename))) {
            throw new \InvalidArgumentException(sprintf('The dir "%s" is not writable', dirname($filename)));
        }
        $this->filename = $filename;
    }

    /**
     * @inheritdoc
     */
    public function store(MetricInterface $metric)
    {
        $json = json_encode([
            'date' => $metric->getDateTime()->format('r'),
            'type' => $metric->getType(),
            'data' => $metric->getData(),
        ]);
        if (!$json) {
            throw new StorageException('JSON encoding failed');
        }

        $file = $this->getFile();
        $file->fwrite($json . PHP_EOL);
    }

    /**
     * @return \SplFileObject
     */
    private function getFile()
    {
        if (!$this->file) {
            $this->file = new \SplFileObject($this->filename, 'a');
        }

        return $this->file;
    }
}
