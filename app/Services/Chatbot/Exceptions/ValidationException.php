<?php

namespace App\Services\Chatbot\Exceptions;

use Exception;

/**
 * Exception thrown when validation fails
 * 
 * This exception is used for input validation errors, configuration validation failures,
 * and other validation-related issues in the chatbot system.
 */
class ValidationException extends Exception
{
    /**
     * Create a new validation exception
     *
     * @param string $message The exception message
     * @param int $code The exception code (default: 0)
     * @param \Throwable|null $previous The previous exception for chaining
     */
    public function __construct(string $message = "Validation failed", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
