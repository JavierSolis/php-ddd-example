<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testValidPassword(): void
    {
        $password = new Password('Password123!');
        $this->assertInstanceOf(Password::class, $password);
        $this->assertNotEmpty($password->getPasswordHash());
    }

    public function testShortPassword(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must be at least 8 characters long.");
        new Password('Pass1!');
    }

    public function testMissingUppercase(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must contain at least one uppercase letter.");
        new Password('password123!');
    }

    public function testMissingNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must contain at least one number.");
        new Password('Password!');
    }

    public function testMissingSpecialCharacter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must contain at least one special character.");
        new Password('Password123');
    }

    public function testVerifyPassword(): void
    {
        $password = new Password('Password123!');
        $this->assertTrue($password->verify('Password123!'));
        $this->assertFalse($password->verify('WrongPassword'));
    }
}