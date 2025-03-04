<?php

namespace App\Infrastructure\Presentation\Controller;

use App\Application\UseCase\RegisterUser;
use App\Infrastructure\Presentation\DTO\RegisterUserDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/users')]
class RegisterUserController
{
    public function __construct(
        private RegisterUser $registerUser,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), RegisterUserDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }
        return new JsonResponse(['message' => 'Usuario registrado correctamente'], 201);

        try {
            $this->registerUser->execute($dto->name, $dto->email, $dto->password);
            return new JsonResponse(['message' => 'Usuario registrado correctamente'], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}