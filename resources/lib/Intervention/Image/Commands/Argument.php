<?php

namespace Intervention\Image\Commands;

use Intervention\Image\Exception\InvalidArgumentException;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

class Argument {
    /**
     * Command with arguments
     *
     * @var AbstractCommand
     */
    public $command;

    /**
     * Key of argument in array
     *
     * @var int
     */
    public $key;

    /**
     * Creates new instance from given command and key
     *
     * @param AbstractCommand $command
     * @param int             $key
     */
    public function __construct(AbstractCommand $command, $key = 0) {
        $this->command = $command;
        $this->key = $key;
    }

    /**
     * Defines current argument as required
     *
     * @return Argument
     */
    public function required() {
        if(!array_key_exists($this->key, $this->command->arguments)) {
            throw new InvalidArgumentException(sprintf("Missing argument %d for %s", $this->key + 1, $this->getCommandName()));
        }

        return $this;
    }

    /**
     * Returns name of current arguments command
     *
     * @return string
     */
    public function getCommandName() {
        preg_match("/\\\\([\w]+)Command$/", get_class($this->command), $matches);
        return isset($matches[1]) ? lcfirst($matches[1]).'()' : 'Method';
    }

    /**
     * Determines that current argument value must be numeric between given values
     *
     * @return Argument
     */
    public function between($x, $y) {
        $value = $this->type('numeric')->value();

        if(is_null($value)) {
            return $this;
        }

        $alpha = min($x, $y);
        $omega = max($x, $y);

        if($value < $alpha || $value > $omega) {
            throw new InvalidArgumentException(sprintf('Argument %d must be between %s and %s.', $this->key, $x, $y));
        }

        return $this;
    }

    /**
     * Returns value of current argument
     *
     * @param mixed $default
     * @return mixed
     */
    public function value($default = null) {
        $arguments = $this->command->arguments;

        if(is_array($arguments)) {
            return isset($arguments[$this->key]) ? $arguments[$this->key] : $default;
        }

        return $default;
    }

    /**
     * Determines that current argument must be of given type
     *
     * @return Argument
     */
    public function type($type) {
        $valid = true;
        $value = $this->value();

        if($value === null) {
            return $this;
        }

        switch(strtolower($type)) {
            case 'bool':
            case 'boolean':
                $valid = is_bool($value);
                $message = '%s accepts only boolean values as argument %d.';
                break;
            case 'int':
            case 'integer':
                $valid = is_int($value);
                $message = '%s accepts only integer values as argument %d.';
                break;
            case 'num':
            case 'numeric':
                $valid = is_numeric($value);
                $message = '%s accepts only numeric values as argument %d.';
                break;
            case 'str':
            case 'string':
                $valid = is_string($value);
                $message = '%s accepts only string values as argument %d.';
                break;
            case 'array':
                $valid = is_array($value);
                $message = '%s accepts only array as argument %d.';
                break;
            case 'closure':
                $valid = is_a($value, '\Closure');
                $message = '%s accepts only Closure as argument %d.';
                break;
            case 'digit':
                $valid = $this->isDigit($value);
                $message = '%s accepts only integer values as argument %d.';
                break;
        }

        if(!$valid) {
            $commandName = $this->getCommandName();
            $argument = $this->key + 1;

            if(isset($message)) {
                $message = sprintf($message, $commandName, $argument);
            }
            else {
                $message = sprintf('Missing argument for %d.', $argument);
            }

            throw new InvalidArgumentException($message);
        }

        return $this;
    }

    /**
     * Checks if value is "PHP" integer (120 but also 120.0)
     *
     * @param mixed $value
     * @return boolean
     */
    private function isDigit($value) {
        return is_numeric($value) ? intval($value) == $value : false;
    }

    /**
     * Determines that current argument must be over a minimum value
     *
     * @return Argument
     */
    public function min($value) {
        $v = $this->type('numeric')->value();

        if(is_null($v)) {
            return $this;
        }

        if($v < $value) {
            throw new InvalidArgumentException(sprintf('Argument %d must be at least %s.', $this->key, $value));
        }

        return $this;
    }

    /**
     * Determines that current argument must be under a maxiumum value
     *
     * @return Argument
     */
    public function max($value) {
        $v = $this->type('numeric')->value();

        if(is_null($v)) {
            return $this;
        }

        if($v > $value) {
            throw new InvalidArgumentException(sprintf('Argument %d may not be greater than %s.', $this->key, $value));
        }

        return $this;
    }
}
