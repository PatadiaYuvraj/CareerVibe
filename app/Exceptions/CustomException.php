<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message);
    }
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render()
    {
        return response()->json([
            "error" => true,
            "message" => $this->getMessage()
        ]);
    }
}
