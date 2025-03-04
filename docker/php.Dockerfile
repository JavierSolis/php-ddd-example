FROM php:8.2-fpm-alpine

ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN apk update && apk add --no-cache \
    freetype \
    libjpeg-turbo \
    libpng \
    libzip \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    git \
    autoconf \
    build-base \
    linux-headers \
    mysql-client \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_mysql \
    zip \
    bcmath \
    && apk del --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    build-base \
    linux-headers

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY ./app .

RUN echo "memory_limit=1G" > /usr/local/etc/php/conf.d/memory-limit.ini

RUN chown -R laravel:laravel /var/www/html