<?php

namespace App\Tests\Integration;

use App\Application\UseCase\RegisterUser;
use App\Infrastructure\Repository\DoctrineUserRepository;
use PHPUnit\Framework\TestCase;

use Doctrine\ORM\Tools\SchemaTool;


class RegisterUserIntegrationTest extends TestCase
{
    private RegisterUser $registerUser;
    private \Doctrine\ORM\EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $container = require __DIR__ . "/../../config/bootstrap.php";
        $this->entityManager = $container['entityManager'];
        $eventDispatcher = $container['eventDispatcher'];

        $this->createSqliteSchema();
        $this->cleanDatabase();

    
        $userRepository = new DoctrineUserRepository($this->entityManager);
        $this->registerUser = new RegisterUser($userRepository, $eventDispatcher);
    }

    private function createSqliteSchema(): void
    {
        //include __DIR__ . '/create_sqlite_schema.php';
        //include __DIR__ . '/sqlite_2.php';

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        try {
            $schemaTool->createSchema($metadata);
            echo "SQLite schema created.\n"; // Agregar esta línea
        } catch (\Exception $e) {
            echo "Error creating SQLite schema: " . $e->getMessage() . "\n";
        }

        echo "SQLite schema created.\n"; // Agregar esta línea
    }

    private function cleanDatabase(): void
    {
        echo "SQLite cleanDatabase.\n"; // Agregar esta línea

        $connection = $this->entityManager->getConnection();
        $connection->executeStatement('DELETE FROM users');
    }

    public function testExecute(): void
    {
        echo "SQLite testExecute.\n"; // Agregar esta línea

        //try {
            $email = 'john.doe.' . uniqid() . '.integration@example.com';
            $this->registerUser->execute('John Doe', $email, 'Password123!');
            $this->assertTrue(true, "User registered successfully!");
        //} catch (\Exception $e) {
        //    $this->fail("Error: " . $e->getMessage());
        //}
    }
}