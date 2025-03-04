<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Password;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Persistence\Entity\UserPersistence;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Infrastructure\Exceptions\UserAlreadyExistsException;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        if ($this->findByEmail($user->getEmail())) {
            throw new UserAlreadyExistsException('El email ya existe.');
        }

        $this->entityManager->beginTransaction();
        try {
            $userPersistence = new UserPersistence();
            $userPersistence->setId($user->getId()->getId());
            $userPersistence->setName($user->getName()->getName());
            $userPersistence->setEmail($user->getEmail()->getEmail());
            $userPersistence->setPassword($user->getPassword()->getPasswordHash());
            //$userPersistence->setCreatedAt(new \DateTimeImmutable());
            $userPersistence->setCreatedAt(new \DateTime($user->getCreatedAt()->format('Y-m-d H:i:s'))); // Convierte a DateTime

            $this->entityManager->persist($userPersistence);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function findById(UserId $id): ?User
    {
        $userPersistence = $this->entityManager->find(UserPersistence::class, $id->getId());

        if (!$userPersistence) {
            throw new UserNotFoundException("User with ID: " . $id->getId() . " not found.");
        }

        return $this->mapUserPersistenceToUser($userPersistence);
    }

    public function findByEmail(Email $email): ?User
    {
        $userPersistence = $this->entityManager->getRepository(UserPersistence::class)->findOneBy(['email' => $email->getEmail()]);

        if (!$userPersistence) {
            //throw new UserNotFoundException("User with email: " . $email->getEmail() . " not found.");
            return null;
        }

        return $this->mapUserPersistenceToUser($userPersistence);
    }

    public function delete(UserId $id): void
    {
        $this->entityManager->beginTransaction();
        try {
            $userPersistence = $this->entityManager->find(UserPersistence::class, $id->getId());

            if ($userPersistence) {
                $this->entityManager->remove($userPersistence);
                $this->entityManager->flush();
                $this->entityManager->commit();
            }
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    private function mapUserPersistenceToUser(UserPersistence $userPersistence): User
    {
        return new User(
            new UserId($userPersistence->getId()),
            new Name($userPersistence->getName()),
            new Email($userPersistence->getEmail()),
            new Password($userPersistence->getPassword())
        );
    }
}