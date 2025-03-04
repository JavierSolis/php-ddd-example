<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testValidName(): void
    {
        $name = new Name('John Doe');
        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals('John Doe', $name->getName());
        $this->assertEquals('John Doe', (string) $name);
    }

    public function testShortName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Name must be at least 3 characters long.");
        new Name('Jo');
    }

    public function testInvalidCharacters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Name contains invalid characters.");
        new Name('John123');
    }

    public function testNameWithNumbers(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Name contains invalid characters.");
        new Name('John 123');
    }

    public function testNameWithSpecialCharacters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Name contains invalid characters.");
        new Name('John Doe!');
    }
}