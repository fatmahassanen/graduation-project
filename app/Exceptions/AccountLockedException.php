<?php

namespace App\Exceptions;

use Exception;

class AccountLockedException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message = 'Account locked for 15 minutes due to failed login attempts', int $code = 423)
    {
        parent::__construct($message, $code);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render()
    {
        return response()->json([
            'error' => $this->getMessage(),
            'locked' => true,
        ], $this->code);
    }
}
