FROM php:8-fpm

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql