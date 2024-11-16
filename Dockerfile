# Usa la imagen oficial de PHP desde Docker Hub
FROM php:8.2

# Instala extensiones PHP necesarias
RUN docker-php-ext-install mysqli pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js y NPM
RUN apt-get update && apt-get install -y nodejs npm

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .
RUN ls -la

# Establece permisos para las carpetas de almacenamiento y caché
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Instala dependencias de Composer
RUN composer install

# Instala dependencias de NPM
RUN npm install
RUN npm run build

# Expone el puerto 80
EXPOSE 80

# Ejecuta el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]


