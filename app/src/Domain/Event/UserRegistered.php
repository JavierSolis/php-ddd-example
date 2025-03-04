<?php

namespace App\Domain\Event;

use App\Domain\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegistered extends Event
{
    public const NAME = 'user.registered';

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}