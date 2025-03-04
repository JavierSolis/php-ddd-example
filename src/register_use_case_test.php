<?php

require_once __DIR__ . "/../config/bootstrap.php";

use App\Application\UseCase\RegisterUser;
use App\Infrastructure\Repository\DoctrineUserRepository;

$container = require __DIR__ . "/../config/bootstrap.php";
$entityManager = $container['entityManager'];
$eventDispatcher = $container['eventDispatcher'];

$userRepository = new DoctrineUserRepository($entityManager);
$registerUser = new RegisterUser($userRepository, $eventDispatcher);

try {
    $registerUser->execute('John Doe', 'john.doe@example.com', 'Password123!');
    echo "User registered successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}