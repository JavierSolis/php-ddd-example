<?php

namespace App\Tests\Domain\ValueObject;

use App\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email('test@example.com');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('test@example.com', $email->getEmail());
        $this->assertEquals('test@example.com', (string) $email); // Test __toString method
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");
        new Email('invalid-email');
    }

    public function testEmptyEmail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");
        new Email('');
    }

    public function testEmailWithSpaces(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");
        new Email(' test@example.com ');
    }
}