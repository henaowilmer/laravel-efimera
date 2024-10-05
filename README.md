# Proyecto Laravel

Este es un proyecto desarrollado con Laravel que utiliza Docker para la gestión de contenedores. A continuación se detallan los pasos para construir y ejecutar el contenedor, así como para acceder a Artisan y Composer.

## Requisitos Previos

Asegúrate de tener Docker y Docker Compose instalados en tu máquina. 

## Construir y Ejecutar el Contenedor

Para construir y ejecutar el contenedor, utiliza el siguiente comando:

```bash
docker-compose up -d
```

Este comando levantará los contenedores en segundo plano.

## Acceso a Artisan y Composer
Para acceder al contenedor de la aplicación y utilizar Artisan o Composer, ejecuta:

```bash
docker-compose exec app bash
```


## Comandos Útiles
Ejecutar Migraciones
Para ejecutar las migraciones de la base de datos, utiliza:

```bash
php artisan migrate
```

Instalar Dependencias de Composer
Para instalar las dependencias de Composer, ejecuta:

```bash
composer install
```