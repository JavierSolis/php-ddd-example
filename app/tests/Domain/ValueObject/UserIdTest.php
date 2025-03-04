<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\UserId;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    public function testValidUserId(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $userId = new UserId($uuid);
        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertEquals($uuid, $userId->getId());
        $this->assertEquals($uuid, (string) $userId);
    }

    public function testInvalidUserId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid UserId format.");
        new UserId('invalid-uuid');
    }

    public function testCreateUserId(): void
    {
        $userId = UserId::create();
        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertTrue(Uuid::isValid($userId->getId()));
    }
}