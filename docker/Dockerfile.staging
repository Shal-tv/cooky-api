FROM php:8.4-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    librabbitmq-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        zip \
        intl \
        opcache \
    && pecl install apcu amqp \
    && docker-php-ext-enable apcu amqp opcache \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer dump-autoload \
    --optimize \
    --classmap-authoritative

RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

USER www-data

CMD ["php-fpm", "-F"]
