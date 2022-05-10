<?php

namespace App\Exceptions;

/**
 * Used in App\Exception\formValidationException to indicate which fields have failed validation
 */
class formValidationFieldError {

    /**
     * The field name which has failed validation
     * @var string
     */
    private string $name;

    /**
     * The reason for the failed validation
     * @var string
     */
    private string $message;

    public function __construct(string $name, string $message) {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Returns the field name
     * @return string
     */
    public function getField(): string {
        return $this->name;
    }

    /**
     * Returns the reason
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

}