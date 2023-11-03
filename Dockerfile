FROM php:8.1.0-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Configuring folder access
RUN mkdir -p /var/www/storage
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 775 /var/www/storage

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer



