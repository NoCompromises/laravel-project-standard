FROM php:8.3.11-fpm-alpine3.20 AS base

RUN apk add --no-cache $PHPIZE_DEPS \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    zip

# the install command for an extension must immediately follow the configure command
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install zip

RUN pecl install redis-6.0.2 && docker-php-ext-enable redis

# install composer from the composer image
COPY --from=composer:2.7.7 /usr/bin/composer /usr/bin/composer

COPY docker-php-file-uploads.ini /usr/local/etc/php/conf.d/docker-php-file-uploads.ini

FROM base AS debug

# Supports xdebug
RUN apk add --update linux-headers
RUN pecl install xdebug-3.3.2 && docker-php-ext-enable xdebug
COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
