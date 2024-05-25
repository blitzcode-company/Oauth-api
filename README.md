# Oauth-api

<p align="center">
    <img src="https://drive.google.com/uc?export=download&id=1yyVoEHmLQgzYpDJJJvjtpo1MHdZNP84k" width="200">
</p>

### Configuración del proyecto

-   Para comenzar, clona el repositorio de GitHub a tu máquina local. Abre una terminal y ejecuta el siguiente comando:

`Vía SSH:`

```
git clone git@github.com:blitzcode-company/Oauth-api.git
```

`Vía HTTPS:`

```
git clone https://github.com/blitzcode-company/Oauth-api.git
```

-   Ingresamos al proyecto `cd Oauth-api` y ejecutamos:

```
composer install
```

-   Dentro del directorio del proyecto de Laravel, generamos el archivo .env con el siguiente comando:

```
cp .env.example .env
```

-   Configuramos la base de datos dentro del archivo .env:

```
DB_HOST=mysql
DB_PORT=3306
```

- Generar la clave de la aplicación

```
php artisan key:generate
```

- Crear las claves de Passport:
```
php artisan passport:keys
```
- Crear el cliente de concesión de contraseña (Password Grant Client)
Utiliza el siguiente comando y guarda la `client_id` y `client_secret` generadas:

```
php artisan passport:client --password
```