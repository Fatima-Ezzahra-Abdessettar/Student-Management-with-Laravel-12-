FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Configure GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache

# PHP-FPM listen on TCP
RUN sed -i 's|listen = .*|listen = 0.0.0.0:9000|' /usr/local/etc/php-fpm.d/www.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www

# Copy app
COPY . /var/www

# Entrypoint
RUN chmod +x docker-entrypoint.sh

# Copy custom FPM config
COPY docker/php/conf.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache
