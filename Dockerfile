

# Stage 1: Build frontend assets
FROM node:24-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# Stage 2: Install PHP dependencies
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


# Stage 3: Laravel PHP-FPM application
FROM php:8.4-fpm-bookworm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libsqlite3-dev \
    libonig-dev \
    unzip \
    && docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    bcmath \
    pcntl \
    zip \
    xml \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 9000

CMD ["php-fpm"]
