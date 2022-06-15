<?php

namespace App\Installer;

use \Exception;

/**
 * This class contains information about the step performed in the App\Installer\Installer class
 * such as: if it succeeded or not, what the response is, and possibly what exception was thrown
 */
class InstallStepResult
{

    /**
     * Indicates if the install step has succeeded or not
     * @var bool
     */
    private bool $success;

    /**
     * Contains the output of the install step
     * @var string
     */
    private string $output;

    /**
     * If the install step has failed, this might contain the exception that has been thrown
     * @var Exception|null
     */
    private ?Exception $exception;

    /**
     * @param bool $success
     * @param string $output
     * @param Exception|null $exception
     */
    public function __construct(bool $success, string $output = '', ?Exception $exception = null)
    {
        $this->success = $success;
        $this->output = $output;
        $this->exception = $exception;
    }

    /**
     * Returns if the Install step has succeeded or not
     * @return bool
     */
    public function succeeded(): bool
    {
        return $this->success;
    }

    /**
     * Returns the output from the install step
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * Returns the exception, if any; that has been thrown in the install step
     * @return Exception|null
     */
    public function getException(): ?Exception
    {
        return $this->exception;
    }

}
