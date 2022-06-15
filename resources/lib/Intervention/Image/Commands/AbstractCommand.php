<?php

namespace Intervention\Image\Commands;

use Intervention\Image\Image;

abstract class AbstractCommand
{
    /**
     * Arguments of command
     *
     * @var array
     */
    public $arguments;

    /**
     * Output of command
     *
     * @var mixed
     */
    protected $output;

    /**
     * Creates new command instance
     *
     * @param array $arguments
     */
    public function __construct($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Executes current command on given image
     *
     * @param Image $image
     * @return mixed
     */
    abstract public function execute($image);

    /**
     * Creates new argument instance from given argument key
     *
     * @param int $key
     * @return Argument
     */
    public function argument($key)
    {
        return new Argument($this, $key);
    }

    /**
     * Returns output data of current command
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output ? $this->output : null;
    }

    /**
     * Sets output data of current command
     *
     * @param mixed $value
     */
    public function setOutput($value)
    {
        $this->output = $value;
    }

    /**
     * Determines if current instance has output data
     *
     * @return boolean
     */
    public function hasOutput()
    {
        return !is_null($this->output);
    }
}
