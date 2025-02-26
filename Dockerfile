FROM php:8.0-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Establecer el nuevo DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Actualizar la configuración de Apache para usar el nuevo DocumentRoot
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite
