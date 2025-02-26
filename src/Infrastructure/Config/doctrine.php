<?php
declare(strict_types=1);

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../../../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../../.env');

$paths     = [__DIR__ . '/../../Domain/Model'];
$isDevMode = true;
if (!Type::hasType('user_id')) {
    Type::addType('user_id', \App\Infrastructure\Doctrine\Type\UserIdType::class);
}
// Registrar custom type para Name
if (!Type::hasType('name')) {
    Type::addType('name', \App\Infrastructure\Doctrine\Type\NameType::class);
}
if (!Type::hasType('email')) {
    Type::addType('email', \App\Infrastructure\Doctrine\Type\EmailType::class);
}
if (!Type::hasType('password')) {
    Type::addType('password', \App\Infrastructure\Doctrine\Type\PasswordType::class);
}
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);


// Configuración de conexión a MySQL
$conn = [
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
];

$entityManager = EntityManager::create($conn, $config);

return $entityManager;
