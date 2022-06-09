FROM php:8-fpm

# Add composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install NPM and it's required dependencies (git, zip, unzip)
RUN apt update && apt install -y git zip unzip npm

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql
