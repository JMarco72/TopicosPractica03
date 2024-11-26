# Usa la imagen oficial de PHP desde Docker Hub
FROM php:8.2

# Instala extensiones PHP necesarias y herramientas adicionales
RUN apt-get update && apt-get install -y \
    netcat-openbsd \
    git \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install mysqli pdo_mysql bcmath

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .

# Configura permisos para almacenamiento y caché
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Configura Git para permitir el directorio como seguro
RUN git config --global --add safe.directory /var/www/html

# Permite que Composer se ejecute como superusuario
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Instala dependencias de NPM y compila los recursos
RUN npm install
RUN npm run build

# Expone el puerto 80
EXPOSE 80

# Ejecuta el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]