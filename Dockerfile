# Usa la imagen oficial de PHP desde Docker Hub
FROM php:8.2

# Instala extensiones PHP necesarias
RUN apt-get update && apt-get install -y libzip-dev unzip git \
    && docker-php-ext-install mysqli pdo_mysql zip bcmath

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js y NPM
RUN apt-get install -y nodejs npm

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .

# Configura permisos para evitar problemas con Laravel
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Configura Git para evitar problemas de propiedad
RUN git config --global --add safe.directory /var/www/html

# Permite que Composer se ejecute como superusuario
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instala dependencias de Composer
RUN composer install --ignore-platform-req=ext-bcmath

# Instala dependencias de NPM y compila los recursos
RUN npm install
RUN npm run build

# Expone el puerto 80
EXPOSE 80

# Ejecuta el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
