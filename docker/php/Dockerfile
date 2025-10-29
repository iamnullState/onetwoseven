FROM php:8.3-fpm-alpine

# System deps
RUN apk add --no-cache \
    git bash zip unzip icu-dev oniguruma-dev libzip-dev mariadb-client

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql intl mbstring zip

# Opcache
RUN docker-php-ext-install opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Workdir
WORKDIR /var/www/onetwoseven
