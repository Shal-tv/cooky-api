FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    librabbitmq-dev \
    netcat-openbsd \
    && docker-php-ext-install \
    pdo_pgsql \
    intl \
    opcache \
    && pecl install apcu amqp \
    && docker-php-ext-enable apcu amqp opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY php/opcache-dev.ini /usr/local/etc/php/conf.d/opcache-dev.ini
COPY php/dev-entrypoint.sh /usr/local/bin/dev-entrypoint

RUN chmod +x /usr/local/bin/dev-entrypoint

WORKDIR /var/www/dev/cooky-api

ENTRYPOINT ["dev-entrypoint"]
CMD ["php-fpm"]
