<?php
// cli-config.php
require_once __DIR__ . '/vendor/autoload.php';

// Obtén el EntityManager desde tu configuración de Doctrine
$entityManager = require __DIR__ . '/src/Infrastructure/Config/doctrine.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
