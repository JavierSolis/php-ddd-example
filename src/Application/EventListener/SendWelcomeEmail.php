<?php

namespace App\Application\EventListener;

use App\Domain\Event\UserRegistered;

class SendWelcomeEmail
{
    public function __invoke(UserRegistered $event)
    {
        $user = $event->getUser();
        // Lógica para enviar un email de bienvenida al usuario
        //echo "Email de bienvenida enviado a: " . $user->getEmail()->getEmail() . "\n";
    }
}