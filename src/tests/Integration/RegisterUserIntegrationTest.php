<?php

namespace App\Tests\Integration;

use App\Application\UseCase\RegisterUser;
use App\Infrastructure\Repository\DoctrineUserRepository;
use PHPUnit\Framework\TestCase;

use Doctrine\ORM\Tools\SchemaTool;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;


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
        } catch (\Exception $e) {
            echo "Error creating SQLite schema: " . $e->getMessage() . "\n";
        }

    }

    private function cleanDatabase(): void
    {
        $connection = $this->entityManager->getConnection();
        $connection->executeStatement('DELETE FROM users');
    }

    public function testExecute(): void
    {
        //try {
            $email = 'john.doe.' . uniqid() . '.integration@example.com';
            $this->registerUser->execute('John Doe', $email, 'Password123!');
            $this->assertTrue(true, "User registered successfully!");
        //} catch (\Exception $e) {
        //    $this->fail("Error: " . $e->getMessage());
        //}
    }

}