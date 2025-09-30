FROM php:8.4.8-fpm-alpine3.22 AS base

RUN apk add --no-cache $PHPIZE_DEPS \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    zip

RUN pecl install redis-6.2.0 \
    && rm -rf /tmp/pear

# the install command for an extension must immediately follow the configure command
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pcntl \
    && docker-php-ext-enable redis \
    && docker-php-ext-install zip

COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

HEALTHCHECK --start-period=2s CMD pgrep -f php-fpm\:\.pool | grep . || exit 1

FROM base AS dev

# XDebug functionality for local dev (XDebug requires linux-headers to compile/build)
RUN apk add --no-cache linux-headers \
    && pecl install xdebug-3.4.3 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug
COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
