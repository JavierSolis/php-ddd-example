<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Application\EventListener\SendWelcomeEmail;
use App\Domain\Event\UserRegistered;

require_once __DIR__ . "/../vendor/autoload.php";

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener(UserRegistered::NAME, new SendWelcomeEmail());

return $eventDispatcher;