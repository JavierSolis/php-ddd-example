<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Application\UseCase\RegisterUser;
use App\Presentation\Controller\RegisterUserController;


require __DIR__ . '/vendor/autoload.php';

// Configuración de la aplicación desde bootstrap.php
$container = require __DIR__ . '/config/bootstrap.php';
$entityManager = $container['entityManager'];
$eventDispatcher = $container['eventDispatcher'];

// Instancia del caso de uso
$registerUser = new RegisterUser(new App\Infrastructure\Repository\DoctrineUserRepository($entityManager), $eventDispatcher);

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->post('/api/users', function (Request $request, Response $response) use ($registerUser) {
    $controller = new RegisterUserController($registerUser);
    return $controller->execute($request, $response);
});

$app->get('/', function (Request $request, Response $response){
    $html = file_get_contents(__DIR__ . '/landingpage.html');
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html')->withStatus(200);
});


$app->run();
