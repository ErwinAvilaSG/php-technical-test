# PHP Technical Test

Esta es una aplicación PHP diseñada como prueba técnica, siguiendo principios de Domain-Driven Design (DDD) y Clean Architecture, y usando Doctrine para la persistencia en MySQL.  
La aplicación implementa:
- Entidades inmutables y Value Objects para datos clave.
- Repositorios a través de interfaces y su implementación con Doctrine.
- Un caso de uso para registrar usuarios, desacoplado del controlador.
- Pruebas unitarias y de integración con PHPUnit.
- Despliegue con Docker (PHP/Apache y MySQL).
- Patrón Ports and Adapters para desacoplar la lógica de negocio de la infraestructura.

## Requisitos
Descargar e instalar(en este caso para windows).
- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- Git

## Instalación y Ejecución

1. **Clonar el repositorio:**

   git clone https://github.com/ErwinAvilaSG/php-technical-test.git
   cd php-technical-test

2. **Crear el archivo .env en la raíz (si no existe) con el siguiente contenido**
DB_HOST=db
DB_NAME=php_test
DB_USER=root
DB_PASSWORD=root

3. **Construir y levantar los contenedores Docker**
docker-compose build
docker-compose up -d

4. **Instalar dependencias (si es necesario)**
docker-compose exec php composer install

5. **Actualizar el esquema de la base de datos**
docker-compose exec php vendor/bin/doctrine orm:schema-tool:update --force


6. **Acceder a la aplicación**
La aplicación se sirve en http://localhost:8080/.

Para registrar un usuario, envía una solicitud POST a http://localhost:8080/register con un cuerpo JSON similar a:
{
  "name": "Nombre del usuario",
  "email": "correo@ejemplo.com",
  "password": "ContraseñaFuerte1!"
}

7. **PRUEBAS**
Para ejecutar las pruebas unitarias y de integración, usa:
docker-compose exec php vendor/bin/phpunit

## Notas Adicionales
La aplicación utiliza custom types de Doctrine para mapear los Value Objects (UserId, Name, Email, Password).
El directorio public contiene el front controller (index.php) y el archivo .htaccess para redirigir todas las solicitudes al index.
El archivo cli-config.php es utilizado por Doctrine para interactuar con la consola de migraciones.

## Despliegue
El proyecto está preparado para desplegarse en cualquier máquina con Docker. Basta con clonar el repositorio, configurar el archivo .env y ejecutar los comandos mencionados.