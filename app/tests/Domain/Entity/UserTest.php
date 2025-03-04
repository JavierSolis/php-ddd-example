<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser(): void
    {
        $userId = UserId::create();
        $name = new Name('John Doe');
        $email = new Email('john.doe@example.com');
        $password = new Password('Password123!');

        $user = new User($userId, $name, $email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
        $this->assertInstanceOf(\DateTime::class, $user->getCreatedAt());
    }

    public function testGetters(): void
    {
        $userId = UserId::create();
        $name = new Name('Jane Smith');
        $email = new Email('jane.smith@example.com');
        $password = new Password('StrongPassword456!');

        $user = new User($userId, $name, $email, $password);

        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
        $this->assertInstanceOf(\DateTime::class, $user->getCreatedAt());
    }
}