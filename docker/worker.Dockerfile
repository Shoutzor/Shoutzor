FROM php:8-cli

# Install Redis driver
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /code
