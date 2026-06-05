<?php

namespace App\Services\Chatbot\Exceptions;

use Exception;

/**
 * Exception thrown when AI service operations fail
 * 
 * This exception is used for AI API communication errors, authentication failures,
 * rate limiting, timeouts, and other AI service-related issues.
 */
class AIServiceException extends Exception
{
    /**
     * Create a new AI service exception
     *
     * @param string $message The exception message
     * @param int $code The exception code (default: 0)
     * @param \Throwable|null $previous The previous exception for chaining
     */
    public function __construct(string $message = "AI service error occurred", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
