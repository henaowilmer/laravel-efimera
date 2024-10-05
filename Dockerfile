FROM php:8.2-fpm

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos de la aplicación al contenedor
COPY . .

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de Composer
RUN composer install

# Ejecutar comandos después de instalar dependencias (si es necesario)
RUN php artisan key:generate
