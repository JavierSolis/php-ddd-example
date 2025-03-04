<?php
namespace App\Domain\ValueObject;

use Ramsey\Uuid\Uuid;

class UserId
{
    private string $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new \InvalidArgumentException("Invalid UserId format.");
        }
        $this->id = $id;
    }

    public static function create(): UserId
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}