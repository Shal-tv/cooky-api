FROM php:8.4-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpq-dev libzip-dev libicu-dev libonig-dev \
    librabbitmq-dev netcat-openbsd \
 && docker-php-ext-install \
    pdo_pgsql zip intl opcache \
 && pecl install apcu amqp \
 && docker-php-ext-enable apcu amqp opcache \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

COPY php/opcache-dev.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

CMD ["php-fpm"]
