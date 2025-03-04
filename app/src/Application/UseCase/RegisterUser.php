<?php

namespace App\Application\UseCase;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Event\UserRegistered;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Infrastructure\Exceptions\UserAlreadyExistsException;

class RegisterUser
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(string $name, string $email, string $password): User
    {
        if ($this->userRepository->findByEmail(new Email($email))) {
            throw new UserAlreadyExistsException("User with email: " . $email . " already exists.");
        }

        $user = new User(
            UserId::create(),
            new Name($name),
            new Email($email),
            new Password($password)
        );

        $this->userRepository->save($user);

        $this->eventDispatcher->dispatch(new UserRegistered($user), UserRegistered::NAME);

        return $user;
    }
}