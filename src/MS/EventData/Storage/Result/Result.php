<?php

namespace MS\EventData\Storage\Result;

class Result implements ResultInterface {

    /**
     * @var array
     */
    protected $data;

    /**
     * @var bool
     */
    protected $error = false;

    public function __construct($data, $error = false)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->error;
    }

}
