<?php

namespace App\Tests\Integration\Infrastructure;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\UserId;
use App\Infrastructure\Repository\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private DoctrineUserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Obtener el EntityManager desde el contenedor de dependencias
        $container = require __DIR__ . '/../../config/bootstrap.php';
        $this->entityManager = $container['entityManager'];

        // Crear el esquema de la base de datos
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);

        $this->userRepository = new DoctrineUserRepository($this->entityManager);
    }

    public function testSaveAndFindUserByEmail(): void
    {
        $userId = UserId::create();
        $name = new Name('John Doe');
        $email = new Email('john.doe@example.com');
        $password = new Password('Password123!');

        $user = new User($userId, $name, $email, $password);
        $this->userRepository->save($user);

        $foundUser =  $this->userRepository->findByEmail($email);

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($email->getEmail(), $foundUser->getEmail());
    }
}