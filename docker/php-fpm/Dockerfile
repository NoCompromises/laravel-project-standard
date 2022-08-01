FROM php:8.1.8-fpm-alpine3.16 as base

RUN apk add git # useful in CI

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

# install composer from the composer image
COPY --from=composer:2.3.9 /usr/bin/composer /usr/bin/composer

COPY docker-php-file-uploads.ini /usr/local/etc/php/conf.d/docker-php-file-uploads.ini

FROM base as debug

# Supports xdebug
RUN pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug
COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
