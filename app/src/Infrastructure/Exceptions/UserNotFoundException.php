<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct(string $message = "User not found", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}