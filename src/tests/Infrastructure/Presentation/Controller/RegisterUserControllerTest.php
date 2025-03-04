<?php

namespace App\Tests\Infrastructure\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserControllerTest extends WebTestCase
{
    public function testRegister(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/users', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'John Doe',
            'email' => 'john.doe.api@example.com',
            'password' => 'Password123!',
        ]));

        $response = $client->getResponse();
        echo $response->getContent();
        $this->assertJsonStringEqualsJsonString('{"message": "Usuario registrado correctamente"}', $response->getContent());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    // Agrega más pruebas para errores y validaciones
}