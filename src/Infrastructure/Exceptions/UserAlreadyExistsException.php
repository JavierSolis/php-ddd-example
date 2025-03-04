<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class UserAlreadyExistsException extends Exception
{
    public function __construct(string $message = "User already exists", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}