<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Application\UseCase\RegisterUser;
use Doctrine\ORM\Tools\SchemaTool;
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

//creacion de la base de datos
$schemaTool = new SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();
try {
    $schemaTool->createSchema($metadata);
    echo "SQLite schema created.\n"; // Agregar esta línea
} catch (\Exception $e) {
    echo "Error creating SQLite schema: " . $e->getMessage() . "\n";
}
$connection = $entityManager->getConnection();
$connection->executeStatement('DELETE FROM users');


//$app->run();
return $app;
