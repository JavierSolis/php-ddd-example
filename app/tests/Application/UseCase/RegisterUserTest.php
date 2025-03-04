<?php

namespace App\Tests\Application\UseCase;

use App\Application\UseCase\RegisterUser;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Entity\User;
use App\Domain\Event\UserRegistered;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;
use App\Infrastructure\Exceptions\UserAlreadyExistsException;

class RegisterUserTest extends TestCase
{
    public function testExecute_SuccessfulRegistration(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $userRepository->expects($this->once())
            ->method('save')
            ->willReturnCallback(function (User $user) {
                $this->assertInstanceOf(User::class, $user);
            });

        $eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->willReturnCallback(function (Event $event, string $eventName) { // Cambia el tipo a Event
                $this->assertInstanceOf(UserRegistered::class, $event);
                $this->assertEquals(UserRegistered::NAME, $eventName);
                return $event; // Devuelve el evento
            });

        $registerUser = new RegisterUser($userRepository, $eventDispatcher);
        $registerUser->execute('John Doe', 'john.doe@example.com', 'Password123!');
    }

    public function testExecute_DuplicateEmail(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $userRepository->expects($this->once())
            ->method('findByEmail')
            ->willReturn($this->createMock(User::class));

        $this->expectException(UserAlreadyExistsException::class);

        $registerUser = new RegisterUser($userRepository, $eventDispatcher);
        $registerUser->execute('John Doe', 'john.doe@example.com', 'Password123!');
    }
}