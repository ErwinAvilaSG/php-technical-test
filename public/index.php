<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Controller\RegisterUserController;
use App\Application\EventDispatcher\EventDispatcherInterface;

// Obtener el EntityManager desde la configuración de Doctrine
$entityManager = require __DIR__ . '/../src/Infrastructure/Config/doctrine.php';

// Implementación simple del EventDispatcher
$eventDispatcher = new class implements EventDispatcherInterface {
    public function dispatch(object $event): void
    {
        if (get_class($event) === 'App\Domain\Event\UserRegisteredEvent') {
            // Simular envío de email de bienvenida
            error_log("Email de bienvenida enviado.");
        }
    }
};

// Instanciar el repositorio y caso de uso
$userRepository   = new \App\Infrastructure\Repository\DoctrineUserRepository($entityManager);
$registerUserUseCase = new \App\Application\UseCase\RegisterUserUseCase($userRepository, $eventDispatcher);

// Instanciar el controlador
$controller = new RegisterUserController($registerUserUseCase);

// Ruteo básico
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
