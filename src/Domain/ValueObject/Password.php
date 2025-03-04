<?php

namespace App\Domain\ValueObject;

class Password
{
    private string $passwordHash;

    public function __construct(string $password)
    {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException("Password must be at least 8 characters long.");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new \InvalidArgumentException("Password must contain at least one uppercase letter.");
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new \InvalidArgumentException("Password must contain at least one number.");
        }
        if (!preg_match('/[^a-zA-Z0-9\s]/', $password)) {
            throw new \InvalidArgumentException("Password must contain at least one special character.");
        }
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function verify(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}