<?php

namespace App\Presentation\Controller;

use App\Application\UseCase\RegisterUser;
use App\Infrastructure\Exceptions\InvalidEmailException;
use App\Infrastructure\Exceptions\WeakPasswordException;
use App\Infrastructure\Exceptions\UserAlreadyExistsException;
use App\Presentation\DTO\UserResponseDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterUserController
{
    private $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function execute(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        try {
            if (!isset($data['name'], $data['email'], $data['password'])) {
                throw new \Exception('Datos incompletos.');
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new InvalidEmailException('Email no válido.');
            }

            $password = $data['password'];
            if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
                throw new WeakPasswordException('La contraseña no cumple los requisitos.');
            }

            $user = $this->registerUser->execute($data['name'], $data['email'], $data['password']);

            $dto = new UserResponseDTO($user->getId(), $user->getName(), $user->getEmail());
            $payload = json_encode($dto->toArray());

            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (InvalidEmailException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (WeakPasswordException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (UserAlreadyExistsException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}