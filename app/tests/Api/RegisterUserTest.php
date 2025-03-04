<?php

namespace App\Tests\Api;

use PHPUnit\Framework\TestCase;
//use Nyholm\Psr7\Factory\StreamFactory;
use Nyholm\Psr7\Stream;

//use Nyholm\Psr7\Request;
use Nyholm\Psr7\ServerRequest; // Cambiado a ServerRequest

use Nyholm\Psr7\Uri;



class RegisterUserTest extends TestCase
{
    //private $url = 'http://127.0.0.1/api/users';
    private $url = 'http://nginx/api/users';
    private $app;
    protected function setUp(): void
    {
        parent::setUp();
        $this->app = $this->getSlimApp();
    }


    public function testRegisterSuccess(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Password123!',
        ];

        $response = $this->sendRequest($data);

        $this->assertEquals(201, $response['statusCode']);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('email', $response['data']);
        $this->assertEquals('John Doe', $response['data']['name']);
        $this->assertEquals('john.doe@example.com', $response['data']['email']);
    }

    public function testRegisterInvalidEmail(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe',
            'password' => 'Password123!',
        ];

        $response = $this->sendRequest($data);

        $this->assertEquals(400, $response['statusCode']);
        $this->assertArrayHasKey('error', $response['data']);
    }

    public function testRegisterWeakPassword(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ];

        $response = $this->sendRequest($data);

        $this->assertEquals(400, $response['statusCode']);
        $this->assertArrayHasKey('error', $response['data']);
        $this->assertEquals('La contraseña no cumple los requisitos.', $response['data']['error']);
    }

    public function testRegisterUserAlreadyExists(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Password123!',
        ];

        // Registra un usuario para que el email exista
        $this->sendRequest($data);

        // Intenta registrar el mismo usuario nuevamente
        $response = $this->sendRequest($data);

        $this->assertEquals(400, $response['statusCode']);
        $this->assertArrayHasKey('error', $response['data']);
        $this->assertEquals('User with email: john.doe@example.com already exists.', $response['data']['error']);
    }

    public function testRegisterShortPassword(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Pass1!',
        ];

        $response = $this->sendRequest($data);

        $this->assertEquals(400, $response['statusCode']);
        //$this->assertArrayHasKey('error', $response['data']);
        $this->assertEquals('La contraseña no cumple los requisitos.', $response['data']['error']);
    }

    private function sendRequest(array $data): array
    {
        $uri = new Uri($this->url);
        $handle = fopen('php://temp', 'w+');
        fwrite($handle, json_encode($data));
        fseek($handle, 0);

        // Reemplazamos StreamFactory con Stream::create
        $stream = Stream::create($handle);

        $request = new ServerRequest('POST', $uri, ['Content-Type' => 'application/json'], $stream);

        $response = $this->app->handle($request);

        return [
            'statusCode' => $response->getStatusCode(),
            'data' => json_decode((string) $response->getBody(), true),
        ];
    }

    private function getSlimApp() {
        return require __DIR__ . '/../../index_test.php';
    }
}