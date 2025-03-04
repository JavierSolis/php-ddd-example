<?php

namespace App\Tests\Domain\Event;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\Event\UserRegistered;
use PHPUnit\Framework\TestCase;

class UserRegisteredTest extends TestCase
{
    public function testGetUser(): void
    {
        $user = new User(
            UserId::create(),
            new Name('John Doe'),
            new Email('john.doe@example.com'),
            new Password('Password123!')
        );

        $event = new UserRegistered($user);
        $this->assertEquals($user, $event->getUser());
    }
}