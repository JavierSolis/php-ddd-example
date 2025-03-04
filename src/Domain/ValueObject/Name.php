<?php

namespace App\Domain\ValueObject;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException("Name must be at least 3 characters long.");
        }
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            throw new \InvalidArgumentException("Name contains invalid characters.");
        }
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}